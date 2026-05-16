<?php

/**
 * Global helper functions used throughout controllers and views.
 *
 * This file is loaded once per request by the front controller
 * (public/index.php) via require, making these functions available
 * everywhere without needing a use/import statement.
 */

use Core\Response;

/**
 * Dump a value and stop execution. Debugging tool.
 *
 * @param  mixed $value  The value to inspect.
 * @return never
 */
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

/**
 * Check if the current request URI matches the given path.
 *
 * Useful in navigation views to highlight the active link.
 *
 * @param  string $value  The path to compare against (e.g. "/plants").
 * @return bool
 */
function urlIs($value)
{
    return $_SERVER["REQUEST_URI"] === $value;
}

/**
 * Halt execution and render an error page.
 *
 * @param  int $code  HTTP status code (default: 404).
 * @return never
 */
function abort($code = 404)
{
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}

/**
 * Abort with an error page if the condition is false.
 *
 * Used in controllers to enforce ownership/permissions:
 *   authorize($plant["user_id"] === $_SESSION["user"]["id"]);
 *
 * @param  mixed $condition  A truthy/falsy value. If false, aborts.
 * @param  int   $status     HTTP status code to abort with (default: 403 Forbidden).
 * @return void
 */
function authorize($condition, $status = Response::FORBIDDEN)
{
    if (!$condition) {
        abort($status);
    }
}

/**
 * Resolve the full filesystem path from a project-relative path.
 *
 * BASE_PATH is defined in public/index.php and points to the project root.
 *
 * @param  string $path  Relative path (e.g. "views/plants/index.view.php").
 * @return string        Absolute path.
 */
function base_path($path)
{
    return BASE_PATH . $path;
}

/**
 * Render a view template, passing data as local variables.
 *
 * extract() converts array keys into variables, so:
 *   view("plants/index.view.php", ["plants" => $plants])
 * makes $plants available inside the view file.
 *
 * @param  string $path        View path relative to views/ (e.g. "plants/index.view.php").
 * @param  array  $attributes  Key-value pairs to pass to the view.
 * @return void
 */
function view($path, $attributes = [])
{
    // extract turns ["plants" => [...], "heading" => "..."] into
    // local variables $plants and $heading inside this function scope.
    // The require'd view file inherits this scope, so it can use them.
    extract($attributes);

    require base_path("views/" . $path);
}

/**
 * Redirect the browser to a different URL and stop execution.
 *
 * @param  string $path  The URL to redirect to (e.g. "/plants").
 * @return never
 */
function redirect($path)
{
    header("location: {$path}");
    exit();
}

/**
 * Retrieve the old form input value for the given field.
 *
 * Used in views to re-populate form fields after a validation failure.
 * Reads from flash data, which is set in public/index.php when a
 * ValidationException is caught.
 *
 * @param  string $key      The form field name (e.g. "email").
 * @param  string $default  Fallback value if no old input exists.
 * @return string
 */
function old($key, $default = "")
{
    return $_SESSION["_flash"]["old"][$key] ?? $default;
}

/**
 * Completely destroy the session — both server-side data and the
 * browser cookie. Used for logging out.
 *
 * @return void
 */
function destroy_session()
{
    $_SESSION = [];

    session_destroy();

    // Tell the browser to delete the PHPSESSID cookie by setting its
    // expiry to one hour in the past. Without this, the browser would
    // keep sending the old (now invalid) session ID on future requests.
    // session_get_cookie_params() retrieves the original cookie settings
    // so the deletion cookie matches exactly — browsers only delete a
    // cookie when the attributes (path, domain, etc.) match.
    $params = session_get_cookie_params();
    setcookie(
        "PHPSESSID",
        "",
        time() - 3600,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"],
    );
}
