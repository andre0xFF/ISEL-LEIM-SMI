<?php

namespace Core;

/**
 * Identifies plants from images using the PlantNet API.
 *
 * The API key is read from the PLANTNET_API_KEY environment variable
 * or from the `settings` table (key "plantnet_api_key").
 *
 * @see https://my-api.plantnet.org/
 */
class PlantNetService
{
    /**
     * Send an image to PlantNet and return the top 3 identification results.
     *
     * @param  string $imagePath  Absolute path to the image file on disk.
     * @return array|null         Array of up to 3 results [{name, score}, ...] or null on error.
     */
    public static function identify(string $imagePath): array|null
    {
        try {
            $apiKey = self::getApiKey();

            if (!$apiKey) {
                return null;
            }

            if (!file_exists($imagePath)) {
                return null;
            }

            $url = "https://my-api.plantnet.org/v2/identify/all"
                 . "?api-key=" . urlencode($apiKey)
                 . "&organs=leaf";

            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_POST           => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_POSTFIELDS     => [
                    "images" => new \CURLFile($imagePath),
                ],
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($response === false || $httpCode !== 200) {
                return null;
            }

            $data = json_decode($response, true);

            if (!$data || empty($data["results"])) {
                return null;
            }

            $results = [];

            foreach (array_slice($data["results"], 0, 3) as $result) {
                $results[] = [
                    "name"  => $result["species"]["scientificName"] ?? "Unknown",
                    "score" => $result["score"] ?? 0,
                ];
            }

            return $results;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Resolve the API key from environment or database settings.
     *
     * @return string|null  The API key, or null if not configured.
     */
    private static function getApiKey(): string|null
    {
        // 1. Try environment variable first
        $envKey = getenv("PLANTNET_API_KEY");

        if ($envKey && $envKey !== "") {
            return $envKey;
        }

        // 2. Fall back to database settings table
        try {
            $db = App::resolve(Database::class);
            $row = $db->query(
                "SELECT `value` FROM settings WHERE `key` = :key",
                ["key" => "plantnet_api_key"],
            )->find();

            if ($row && !empty($row["value"])) {
                return $row["value"];
            }
        } catch (\Throwable $e) {
            // Database not available — fall through
        }

        return null;
    }
}
