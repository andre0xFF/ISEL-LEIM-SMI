<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userId = $_SESSION["user"]["id"];

$tags = $db->query("SELECT * FROM tags ORDER BY type, name")->get();

$subscriptions = $db->query(
    "SELECT tag_id FROM subscriptions WHERE user_id = :user_id",
    ["user_id" => $userId],
)->get();

$subscribedTagIds = array_column($subscriptions, "tag_id");

view("subscriptions/index.view.php", [
    "heading" => "My Subscriptions",
    "tags" => $tags,
    "subscribedTagIds" => $subscribedTagIds,
]);
