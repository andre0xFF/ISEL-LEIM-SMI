<?php

use Core\Installer;

// Only relevant while the schema is missing — the front controller's
// first-run guard sends every other state to the right place, so this
// just covers direct visits once everything is installed.
if (Installer::state() !== "schema_missing") {
    redirect("/");
}

view("install/schema.view.php", [
    "errors" => [],
    "dbname" => Installer::config()["database"]["dbname"],
]);
