<?php

/**
 * Application Bootstrap — registers shared services in the dependency container.
 *
 * This file is loaded once per request by the front controller (public/index.php).
 * It wires up everything the application needs (currently just the database)
 * so controllers can retrieve them later with App::resolve(Database::class).
 */

use Core\App;
use Core\Container;
use Core\Database;

$container = new Container();

// Register a factory for the Database class. The callable is only invoked
// when a controller calls App::resolve(Database::class), not at boot time.
$container->bind("Core\Database", function () {
    // config.php returns an array with 'database', 'username', and 'password'
    // keys, reading from environment variables with fallback defaults.
    $config = require base_path("config.php");

    return new Database(
        $config["database"],
        $config["username"],
        $config["password"],
    );
});

// Make the container globally accessible via App::resolve().
App::setContainer($container);
