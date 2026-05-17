<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$errors = [];

// ── Validate the uploaded zip file ──────────────────────────────────

if (
    empty($_FILES["zipfile"]["tmp_name"]) ||
    $_FILES["zipfile"]["error"] !== UPLOAD_ERR_OK
) {
    $errors["zipfile"] = "Please upload a valid .zip file.";
    return view("media/batch-upload.view.php", [
        "heading" => "Batch Upload",
        "errors" => $errors,
    ]);
}

$mime = mime_content_type($_FILES["zipfile"]["tmp_name"]);
if (!in_array($mime, ["application/zip", "application/x-zip-compressed"])) {
    $errors["zipfile"] = "The uploaded file must be a .zip archive.";
    return view("media/batch-upload.view.php", [
        "heading" => "Batch Upload",
        "errors" => $errors,
    ]);
}

// ── Extract the zip to a temp directory ─────────────────────────────

$tmpDir = sys_get_temp_dir() . "/rooted_batch_" . uniqid("", true);
mkdir($tmpDir, 0755, true);

$zip = new ZipArchive();

if ($zip->open($_FILES["zipfile"]["tmp_name"]) !== true) {
    $errors["zipfile"] = "Could not open the zip file.";
    return view("media/batch-upload.view.php", [
        "heading" => "Batch Upload",
        "errors" => $errors,
    ]);
}

$zip->extractTo($tmpDir);
$zip->close();

// ── Locate and parse metadata.xml ───────────────────────────────────

$xmlPath = $tmpDir . "/metadata.xml";

if (!file_exists($xmlPath)) {
    cleanUpDir($tmpDir);
    $errors["zipfile"] = "The zip must contain a metadata.xml file.";
    return view("media/batch-upload.view.php", [
        "heading" => "Batch Upload",
        "errors" => $errors,
    ]);
}

libxml_use_internal_errors(true);
$xml = simplexml_load_file($xmlPath);

if ($xml === false) {
    cleanUpDir($tmpDir);
    $errors["zipfile"] = "metadata.xml is not valid XML.";
    return view("media/batch-upload.view.php", [
        "heading" => "Batch Upload",
        "errors" => $errors,
    ]);
}

// ── Ensure the media storage directory exists ───────────────────────

$storagePath = base_path("storage/app/media/");
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0755, true);
}

// ── Process each <plant> element ────────────────────────────────────

$userId = $_SESSION["user"]["id"];
$importedCount = 0;

foreach ($xml->plant as $plantNode) {
    $name       = trim((string) ($plantNode->name ?? ""));
    $body       = trim((string) ($plantNode->body ?? ""));
    $visibility = trim((string) ($plantNode->visibility ?? "public"));

    if ($name === "") {
        continue; // skip plants without a name
    }

    if (!in_array($visibility, ["public", "internal"])) {
        $visibility = "public";
    }

    // 1. Insert the plant
    $db->query(
        "INSERT INTO plants (user_id, name, body, visibility) VALUES (:user_id, :name, :body, :visibility)",
        [
            "user_id"    => $userId,
            "name"       => $name,
            "body"       => $body,
            "visibility" => $visibility,
        ],
    );
    $plantId = (int) $db->lastInsertId();

    // 2. Process <files>
    if (isset($plantNode->files)) {
        foreach ($plantNode->files->file as $fileNode) {
            $filename = trim((string) $fileNode);
            if ($filename === "") {
                continue;
            }

            // Look for the file in the extracted directory (root or subdirectories)
            $sourcePath = findFileRecursive($tmpDir, $filename);
            if (!$sourcePath || !file_exists($sourcePath)) {
                continue;
            }

            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $uniqueName = uniqid("", true) . "." . $ext;
            $relativePath = "media/" . $uniqueName;
            $absolutePath = base_path("storage/app/" . $relativePath);

            copy($sourcePath, $absolutePath);

            $mimeType = mime_content_type($absolutePath) ?: "application/octet-stream";
            $mediaType = "image";
            if (str_starts_with($mimeType, "video/")) {
                $mediaType = "video";
            } elseif (str_starts_with($mimeType, "audio/")) {
                $mediaType = "audio";
            }

            $db->query(
                "INSERT INTO media (plant_id, type, path, filename, mime_type)
                 VALUES (:plant_id, :type, :path, :filename, :mime_type)",
                [
                    "plant_id"  => $plantId,
                    "type"      => $mediaType,
                    "path"      => $relativePath,
                    "filename"  => $filename,
                    "mime_type" => $mimeType,
                ],
            );
        }
    }

    // 3. Process <tags>
    if (isset($plantNode->tags)) {
        foreach ($plantNode->tags->tag as $tagNode) {
            $tagName = trim((string) $tagNode);
            if ($tagName === "") {
                continue;
            }

            $tag = $db->query(
                "SELECT id FROM tags WHERE name = :name",
                ["name" => $tagName],
            )->find();

            if ($tag) {
                $db->query(
                    "INSERT INTO plant_tag (plant_id, tag_id) VALUES (:pid, :tid)",
                    ["pid" => $plantId, "tid" => (int) $tag["id"]],
                );
            }
        }
    }

    // 4. Process <meta>
    if (isset($plantNode->meta)) {
        foreach ($plantNode->meta->item as $itemNode) {
            $metaKey   = trim((string) ($itemNode["key"] ?? ""));
            $metaValue = trim((string) ($itemNode["value"] ?? ""));
            if ($metaKey === "") {
                continue;
            }

            $db->query(
                "INSERT INTO plant_meta (plant_id, `key`, `value`) VALUES (:pid, :k, :v)",
                [
                    "pid" => $plantId,
                    "k"   => $metaKey,
                    "v"   => $metaValue,
                ],
            );
        }
    }

    $importedCount++;
}

// ── Clean up and redirect ───────────────────────────────────────────

cleanUpDir($tmpDir);

$_SESSION["_flash"]["success"] = "Successfully imported {$importedCount} plant(s).";

redirect("/plants");

// ── Helper functions ────────────────────────────────────────────────

/**
 * Recursively find a file by name inside a directory.
 */
function findFileRecursive(string $dir, string $filename): string|null
{
    $path = $dir . "/" . $filename;
    if (file_exists($path)) {
        return $path;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
    );

    foreach ($iterator as $file) {
        if ($file->getFilename() === $filename) {
            return $file->getPathname();
        }
    }

    return null;
}

/**
 * Recursively delete a directory and its contents.
 */
function cleanUpDir(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST,
    );

    foreach ($iterator as $item) {
        if ($item->isDir()) {
            rmdir($item->getPathname());
        } else {
            unlink($item->getPathname());
        }
    }

    rmdir($dir);
}
