<?php

use Core\Response;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($value)
{
    return $_SERVER["REQUEST_URI"] === $value;
}

function abort($code = 404)
{
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}

function authorize($condition, $status = Response::FORBIDDEN)
{
    if (!$condition) {
        abort($status);
    }

    return true;
}

function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);

    require base_path("views/" . $path);
}

function redirect($path)
{
    header("location: {$path}");
    exit();
}

/**
 * Retrieve the old form input value for the given field.
 *
 * Used in views to re-populate form fields after a validation failure.
 */
function old($key, $default = "")
{
    return $_SESSION["_flash"]["old"][$key] ?? $default;
}

/**
 * Completely destroy the session — both server-side data and the
 * browser cookie. Used for logging out.
 */
function destroy_session()
{
    $_SESSION = [];

    session_destroy();

    // Tell the browser to delete the PHPSESSID cookie by setting its
    // expiry to one hour in the past. Without this, the browser would
    // keep sending the old (now invalid) session ID on future requests.
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
