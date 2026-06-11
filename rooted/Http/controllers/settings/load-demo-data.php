<?php

use Core\App;
use Core\Database;
use Core\Installer;

/**
 * Load demo/sample content from database/002-seed.sql (admin only).
 *
 * Refuses to run if demo data (or any plants/tags) already exists, so it
 * can't duplicate or mis-link content. Runs in a transaction — a failure
 * leaves the database unchanged. The seed's `settings` rows are skipped
 * to preserve the admin's configured SMTP/app settings.
 */

$pdo = App::resolve(Database::class)->connection;

if (!Installer::canLoadDemoData($pdo)) {
    $_SESSION["_flash"]["errors"] = [
        "demo_data" =>
            "Demo data can only be loaded immediately after setup, before any other users, plants or tags exist.",
    ];

    redirect("/settings");
}

try {
    Installer::runSeed($pdo);
} catch (PDOException $e) {
    $_SESSION["_flash"]["errors"] = [
        "demo_data" => "Loading demo data failed: " . $e->getMessage(),
    ];

    redirect("/settings");
}

$_SESSION["_flash"]["success"] =
    "Demo data loaded — sample users, plants, tags and subscriptions are now available. " .
    "All demo account passwords are \"password\".";

redirect("/settings");
