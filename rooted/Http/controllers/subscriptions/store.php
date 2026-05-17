<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$tagId = $_POST["tag_id"] ?? null;
$userId = $_SESSION["user"]["id"];

if ($tagId) {
    $db->query(
        "INSERT IGNORE INTO subscriptions (user_id, tag_id, created_at) VALUES (:user_id, :tag_id, NOW())",
        [
            "user_id" => $userId,
            "tag_id" => (int) $tagId,
        ],
    );
}

redirect("/subscriptions");
