<?php

/**
 * Front Controller — the single entry point for every web request.
 *
 * PHP's built-in server is started with `-t public`, which makes this
 * directory the document root. When no file matches the requested URL,
 * the server falls back to this index.php. Because it's the only PHP
 * file in public/, every dynamic request flows through here.
 *
 * Responsibilities:
 *  1. Bootstrap the application (autoloader, helpers, service container).
 *  2. Build the router and load route definitions.
 *  3. Dispatch the incoming request to the matching controller.
 *  4. Handle validation failures with a redirect + flash messages.
 *  5. Clean up flash data at the end of the request.
 */

use Core\Session;
use Core\ValidationException;

// __DIR__ is the directory of THIS file (public/). Going one level up
// gives us the project root, which is the base for all require paths.
const BASE_PATH = __DIR__ . "/../";

// Resume an existing session or start a new one. This makes $_SESSION
// available for the rest of the request.
session_start();

// Composer's autoloader enables PSR-4 class loading — any `use Core\Router`
// statement will automatically require the corresponding Core/Router.php file.
require BASE_PATH . "vendor/autoload.php";

// Global helper functions (view, redirect, abort, etc.) that are used
// throughout controllers and views but aren't part of a class.
require BASE_PATH . "Core/functions.php";

// Register shared services (e.g. Database) in the dependency container
// so controllers can retrieve them with App::resolve().
require BASE_PATH . "bootstrap.php";

$router = new \Core\Router();

// Load route definitions. routes.php returns a function that receives
// the router, keeping the dependency explicit instead of relying on
// PHP's implicit scope sharing through require.
$routes = require BASE_PATH . "routes.php";
$routes($router);

// Extract the URL path, stripping any query string (?key=value).
$uri = parse_url($_SERVER["REQUEST_URI"])["path"];

// HTML forms only support GET and POST. To use DELETE, PATCH, or PUT,
// forms include a hidden field named "_method" with the desired verb.
// This is known as "method spoofing".
$method = $_POST["_method"] ?? $_SERVER["REQUEST_METHOD"];

try {
    $router->route($uri, $method);
} catch (ValidationException $exception) {
    // Validation failed — flash errors and old input into the session
    // so they survive the redirect, then send the user back to the form.
    Session::flash("errors", $exception->errors);
    Session::flash("old", $exception->old);

    return redirect($router->previousUrl());
}

// Clear flash data so it doesn't leak into the next request.
Session::unflash();
