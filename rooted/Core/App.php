<?php

namespace Core;

use Exception;

/**
 * Simple service container with global static access.
 *
 * Factories are registered once in bootstrap.php with App::bind().
 * Controllers retrieve instances with App::resolve():
 *
 *   $db = App::resolve(Database::class);
 */
class App
{
    /** @var array<string, callable> Registered factory functions keyed by class name. */
    protected static $bindings = [];

    /**
     * Register a factory function for the given key.
     *
     * @param  string   $key       Typically a fully-qualified class name (e.g. 'Core\Database').
     * @param  callable $resolver  A function that creates and returns the instance.
     * @return void
     */
    public static function bind($key, $resolver): void
    {
        static::$bindings[$key] = $resolver;
    }

    /**
     * Build and return the instance registered under the given key.
     *
     * @param  string $key  The key that was used in bind().
     * @return mixed        The object returned by the factory function.
     *
     * @throws Exception If no binding exists for the given key.
     */
    public static function resolve($key)
    {
        if (!array_key_exists($key, static::$bindings)) {
            throw new Exception("No matching binding found for '{$key}'.");
        }

        $resolver = static::$bindings[$key];

        return call_user_func($resolver);
    }
}
