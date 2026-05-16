<?php

namespace Core;

/**
 * A thin wrapper around PHP's $_SESSION superglobal.
 *
 * HTTP is stateless — the server forgets everything between requests.
 * PHP sessions solve this by assigning each visitor a unique ID stored
 * in a cookie (PHPSESSID). On every request, session_start() loads
 * the data associated with that ID into the $_SESSION array.
 *
 * This class adds two features on top of raw $_SESSION access:
 *
 *  1. A clean, static API — Session::get('user') instead of $_SESSION['user'].
 *  2. Flash messages — data that survives exactly ONE request and is then
 *     automatically deleted. This is useful for things like showing a
 *     "Login successful" banner or carrying form validation errors back
 *     to the previous page after a redirect.
 *
 * How flash messages work:
 *   - flash('errors', [...]) stores data that lasts one request.
 *   - get('errors') checks flash data first, then regular session data.
 *   - At the end of every request, unflash() clears all flash data.
 */
class Session
{
    /**
     * Check if a truthy value exists in the session for the given key.
     *
     * Note: returns false for empty strings, 0, null, etc.
     *
     * @param  string $key  The session key to check.
     * @return bool
     */
    public static function has($key)
    {
        return (bool) static::get($key);
    }

    /**
     * Store a value in the session permanently (until manually removed or
     * the session is destroyed).
     *
     * Example:
     *   Session::put('user', ['id' => 1, 'email' => 'admin@rooted.local']);
     *
     * @param  string $key    The session key.
     * @param  mixed  $value  The value to store.
     * @return void
     */
    public static function put($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Retrieve a value from the session.
     *
     * Checks flash data first, then regular session data, then falls
     * back to $default.
     *
     * @param  string $key      The session key to look up.
     * @param  mixed  $default  Value to return if the key doesn't exist (default: null).
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        // ?? is the null coalescing operator: returns the left side if it
        // exists and isn't null, otherwise the right side. Chaining them
        // creates a fallback: flash → session → default.
        return $_SESSION["_flash"][$key] ?? ($_SESSION[$key] ?? $default);
    }

    /**
     * Store a value that will only be available for the next request.
     *
     * Common use case — form validation errors after a redirect:
     *   Session::flash('errors', ['email' => 'Invalid email address']);
     *   redirect('/register');  // next request: get('errors') returns them
     *                           // request after that: they're gone
     *
     * @param  string $key    The flash key.
     * @param  mixed  $value  The value to flash.
     * @return void
     */
    public static function flash($key, $value): void
    {
        // Flash data is stored in a separate '_flash' sub-array so it can
        // be wiped all at once by unflash() without touching regular session data.
        $_SESSION["_flash"][$key] = $value;
    }

    /**
     * Delete all flash data.
     *
     * Called at the end of every request (in public/index.php) so that
     * flash messages only survive one request cycle.
     *
     * @return void
     */
    public static function unflash(): void
    {
        // unset() removes an array key entirely, as opposed to setting it
        // to null (which would leave the key in the array).
        unset($_SESSION["_flash"]);
    }

    /**
     * Clear all session data without destroying the session itself.
     *
     * The session ID and cookie remain intact, but all stored data
     * (including flash data) is wiped.
     *
     * @return void
     */
    public static function flush(): void
    {
        $_SESSION = [];
    }

    /**
     * Completely destroy the session — both server-side data and the
     * browser cookie. Used for logging out.
     *
     * @return void
     */
    public static function destroy(): void
    {
        static::flush();

        // Deletes the session file on the server.
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
}
