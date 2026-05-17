<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$tagId = $_GET["id"] ?? null;
$userId = $_SESSION["user"]["id"];

$db->query(
    "DELETE FROM subscriptions WHERE user_id = :user_id AND tag_id = :tag_id",
    [
        "user_id" => $userId,
        "tag_id" => (int) $tagId,
    ],
);

redirect("/subscriptions");
