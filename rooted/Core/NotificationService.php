<?php

namespace Core;

/**
 * Sends email notifications to subscribers when new content is added.
 */
class NotificationService
{
    /**
     * Notify subscribers when a new plant is created.
     *
     * Finds users who have subscribed to any of the plant's tags,
     * then sends each an email via Mailer.
     */
    public static function notifyNewPlant(int $plantId): void
    {
        $db = App::resolve(Database::class);

        $plant = $db
            ->query("SELECT * FROM plants WHERE id = :id", ["id" => $plantId])
            ->find();

        // Only notify for public plants.
        if (!$plant || $plant["visibility"] !== "public") {
            return;
        }

        // Get tags for this plant.
        $tags = $db
            ->query(
                "SELECT t.id, t.name FROM tags t
                 INNER JOIN plant_tag pt ON pt.tag_id = t.id
                 WHERE pt.plant_id = :pid",
                ["pid" => $plantId],
            )
            ->get();

        if (empty($tags)) {
            return;
        }

        $tagIds = array_column($tags, "id");
        $tagNames = array_column($tags, "name");

        // Build a safe IN clause — IDs come from the DB so intval is sufficient.
        $inList = implode(",", array_map("intval", $tagIds));

        $subscribers = $db
            ->query(
                "SELECT DISTINCT u.email FROM users u
                 INNER JOIN subscriptions s ON s.user_id = u.id
                 WHERE s.tag_id IN ({$inList}) AND u.id != :author",
                ["author" => $plant["user_id"]],
            )
            ->get();

        if (empty($subscribers)) {
            return;
        }

        $appUrl = getenv("APP_URL") ?: "http://localhost:8080";
        $subject = "Rooted — New plant: {$plant["name"]}";
        $body = "A new plant has been added to Rooted!\n\n"
            . "Name: {$plant["name"]}\n"
            . "Tags: " . implode(", ", $tagNames) . "\n\n"
            . "View it at: {$appUrl}/plant?id={$plantId}\n";

        foreach ($subscribers as $sub) {
            Mailer::send($sub["email"], $subject, $body);
        }
    }
}
