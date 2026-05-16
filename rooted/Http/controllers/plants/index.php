<?php

/**
 * GET /plants — List all plants belonging to the logged-in user.
 *
 * This controller follows the standard read pattern:
 *  1. Resolve the database connection from the service container.
 *  2. Query for data using a prepared statement.
 *  3. Pass the results to a view for rendering.
 */

use Core\App;
use Core\Database;

// App::resolve() retrieves the Database instance that was registered
// in bootstrap.php. This is the dependency injection pattern — the
// controller doesn't create the connection itself, it asks the
// container for one.
$db = App::resolve(Database::class);

// Fetch all plants owned by the current user. The :user_id placeholder
// is a prepared statement parameter — the database treats it as data,
// never as SQL, which prevents SQL injection.
// ->get() returns all matching rows as an array of associative arrays.
$plants = $db
    ->query("SELECT * FROM plants WHERE user_id = :user_id", [
        "user_id" => $_SESSION["user"]["id"],
    ])
    ->get();

// Render the view. The second argument is an associative array that
// view() passes to extract(), which turns each key into a local
// variable inside the view file — so $heading and $plants are
// available directly in plants/index.view.php.
view("plants/index.view.php", [
    "heading" => "My Plants",
    "plants" => $plants,
]);
