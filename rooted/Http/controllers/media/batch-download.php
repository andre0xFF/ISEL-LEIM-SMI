<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$userId = $_SESSION["user"]["id"];

// ── Determine which plants to export ────────────────────────────────

$plantId = $_GET["plant_id"] ?? null;

if ($plantId) {
    $plants = $db->query(
        "SELECT * FROM plants WHERE id = :id AND user_id = :uid",
        ["id" => (int) $plantId, "uid" => $userId],
    )->get();

    if (empty($plants)) {
        abort(404);
    }
} else {
    $plants = $db->query(
        "SELECT * FROM plants WHERE user_id = :uid ORDER BY created_at DESC",
        ["uid" => $userId],
    )->get();
}

if (empty($plants)) {
    abort(404);
}

// ── Build the zip archive ───────────────────────────────────────────

$tmpFile = tempnam(sys_get_temp_dir(), "rooted_export_") . ".zip";
$zip = new ZipArchive();

if ($zip->open($tmpFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    abort(500);
}

// Start building the XML
$xmlDoc = new DOMDocument("1.0", "UTF-8");
$xmlDoc->formatOutput = true;
$plantsNode = $xmlDoc->createElement("plants");
$xmlDoc->appendChild($plantsNode);

foreach ($plants as $plant) {
    $plantNode = $xmlDoc->createElement("plant");

    // Basic fields
    $plantNode->appendChild($xmlDoc->createElement("name", htmlspecialchars($plant["name"])));
    $plantNode->appendChild($xmlDoc->createElement("body", htmlspecialchars($plant["body"] ?? "")));
    $plantNode->appendChild($xmlDoc->createElement("visibility", htmlspecialchars($plant["visibility"])));

    // Tags
    $tags = $db->query(
        "SELECT t.name FROM tags t
         INNER JOIN plant_tag pt ON pt.tag_id = t.id
         WHERE pt.plant_id = :pid",
        ["pid" => $plant["id"]],
    )->get();

    $tagsNode = $xmlDoc->createElement("tags");
    foreach ($tags as $tag) {
        $tagsNode->appendChild($xmlDoc->createElement("tag", htmlspecialchars($tag["name"])));
    }
    $plantNode->appendChild($tagsNode);

    // Meta
    $metas = $db->query(
        "SELECT `key`, `value` FROM plant_meta WHERE plant_id = :pid",
        ["pid" => $plant["id"]],
    )->get();

    $metaNode = $xmlDoc->createElement("meta");
    foreach ($metas as $meta) {
        $itemNode = $xmlDoc->createElement("item");
        $itemNode->setAttribute("key", $meta["key"]);
        $itemNode->setAttribute("value", $meta["value"]);
        $metaNode->appendChild($itemNode);
    }
    $plantNode->appendChild($metaNode);

    // Media files
    $mediaFiles = $db->query(
        "SELECT * FROM media WHERE plant_id = :pid",
        ["pid" => $plant["id"]],
    )->get();

    $filesNode = $xmlDoc->createElement("files");

    foreach ($mediaFiles as $media) {
        $filePath = base_path("storage/app/" . $media["path"]);

        if (file_exists($filePath)) {
            // Use a directory per plant to avoid filename collisions
            $zipEntryName = "plant_{$plant["id"]}/" . $media["filename"];
            $zip->addFile($filePath, $zipEntryName);
            $filesNode->appendChild($xmlDoc->createElement("file", htmlspecialchars($media["filename"])));
        }
    }

    $plantNode->appendChild($filesNode);
    $plantsNode->appendChild($plantNode);
}

// Add metadata.xml to the zip
$zip->addFromString("metadata.xml", $xmlDoc->saveXML());
$zip->close();

// ── Send the zip to the browser ─────────────────────────────────────

$fileSize = filesize($tmpFile);

header("Content-Type: application/zip");
header("Content-Disposition: attachment; filename=\"rooted-export.zip\"");
header("Content-Length: " . $fileSize);
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

readfile($tmpFile);

// Clean up
unlink($tmpFile);

exit();
