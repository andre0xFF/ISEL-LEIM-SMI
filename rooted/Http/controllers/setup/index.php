<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$admin = $db->query("SELECT COUNT(*) as cnt FROM users WHERE role = 'admin'")->find();

if ($admin && (int) $admin["cnt"] > 0) {
    redirect("/");
}

view("setup/index.view.php", [
    "heading" => "Setup — Rooted",
    "errors" => [],
]);
