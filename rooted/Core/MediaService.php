<?php

namespace Core;

/**
 * Handles media file upload, retrieval, serving, and deletion.
 *
 * Files are stored on disk under storage/app/media/ and referenced
 * in the `media` database table.
 */
class MediaService
{
    /** Maps MIME types to the media type stored in the DB. */
    private const ALLOWED_TYPES = [
        "image/jpeg" => "image",
        "image/png" => "image",
        "image/gif" => "image",
        "image/webp" => "image",
        "video/mp4" => "video",
        "video/webm" => "video",
        "audio/mpeg" => "audio",
        "audio/ogg" => "audio",
        "audio/wav" => "audio",
    ];

    /**
     * Store a single uploaded file and create a database record.
     *
     * @param  array $file     One entry from $_FILES (keys: name, type, tmp_name, error, size).
     * @param  int   $plantId  The plant this media belongs to.
     * @return array           The inserted media row.
     */
    public static function store(array $file, int $plantId): array
    {
        $mime = $file["type"];
        $mediaType = self::ALLOWED_TYPES[$mime] ?? null;

        if (!$mediaType) {
            throw new \Exception("Unsupported file type: {$mime}");
        }

        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $uniqueName = uniqid("", true) . "." . $ext;
        $relativePath = "media/" . $uniqueName;
        $absolutePath = BASE_PATH . "storage/app/" . $relativePath;

        if (!move_uploaded_file($file["tmp_name"], $absolutePath)) {
            throw new \Exception("Failed to move uploaded file.");
        }

        $db = App::resolve(Database::class);
        $db->query(
            "INSERT INTO media (plant_id, type, path, filename, mime_type)
             VALUES (:plant_id, :type, :path, :filename, :mime_type)",
            [
                "plant_id" => $plantId,
                "type" => $mediaType,
                "path" => $relativePath,
                "filename" => $file["name"],
                "mime_type" => $mime,
            ],
        );

        return [
            "id" => $db->lastInsertId(),
            "path" => $relativePath,
            "type" => $mediaType,
        ];
    }

    /**
     * Store multiple files from a single $_FILES['media'] array.
     */
    public static function storeMultiple(array $files, int $plantId): array
    {
        $results = [];

        if (!isset($files["name"]) || !is_array($files["name"])) {
            return $results;
        }

        for ($i = 0; $i < count($files["name"]); $i++) {
            if ($files["error"][$i] !== UPLOAD_ERR_OK) {
                continue;
            }
            if (empty($files["name"][$i])) {
                continue;
            }

            $results[] = static::store(
                [
                    "name" => $files["name"][$i],
                    "type" => $files["type"][$i],
                    "tmp_name" => $files["tmp_name"][$i],
                    "error" => $files["error"][$i],
                    "size" => $files["size"][$i],
                ],
                $plantId,
            );
        }

        return $results;
    }

    /**
     * Get all media records for a plant.
     */
    public static function getForPlant(int $plantId): array
    {
        return App::resolve(Database::class)
            ->query("SELECT * FROM media WHERE plant_id = :id ORDER BY created_at", [
                "id" => $plantId,
            ])
            ->get();
    }

    /**
     * Find a single media record by ID.
     */
    public static function find(int $id): array|false
    {
        return App::resolve(Database::class)
            ->query("SELECT * FROM media WHERE id = :id", ["id" => $id])
            ->find();
    }

    /**
     * Delete a single media record and its file from disk.
     */
    public static function delete(int $mediaId): void
    {
        $media = static::find($mediaId);
        if (!$media) {
            return;
        }

        $path = BASE_PATH . "storage/app/" . $media["path"];
        if (file_exists($path)) {
            unlink($path);
        }

        App::resolve(Database::class)->query(
            "DELETE FROM media WHERE id = :id",
            ["id" => $mediaId],
        );
    }

    /**
     * Delete all media for a plant (records + files).
     */
    public static function deleteForPlant(int $plantId): void
    {
        $items = static::getForPlant($plantId);

        foreach ($items as $item) {
            $path = BASE_PATH . "storage/app/" . $item["path"];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        App::resolve(Database::class)->query(
            "DELETE FROM media WHERE plant_id = :id",
            ["id" => $plantId],
        );
    }
}
