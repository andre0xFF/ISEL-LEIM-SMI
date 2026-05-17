<?php

namespace Core\Middleware;

/**
 * Registry that maps short string keys to middleware classes.
 *
 * Middleware runs before a controller to guard access. Routes opt in
 * by chaining ->only("auth") or ->only("guest"), and the Router calls
 * Middleware::resolve() with that key before requiring the controller file.
 *
 * Supports two formats:
 *  - Simple key:    "auth"        → instantiates the mapped class with no arguments.
 *  - Parameterized: "role:admin"  → instantiates the mapped class with "admin" as argument.
 *
 * To add new middleware:
 *  1. Create a class with a handle() method in this directory.
 *  2. Add an entry to the MAP constant below.
 *  3. Use the key in routes: $router->get("/admin", "...")->only("your-key");
 */
class Middleware
{
    /** @var array<string, class-string> Maps route keys to middleware class names. */
    public const MAP = [
        "guest" => Guest::class,
        "auth" => Authenticated::class,
        "role" => Role::class,
        "verified" => Verified::class,
    ];

    /**
     * Look up and run the middleware for the given key.
     *
     * If $key is null (route has no middleware), this is a no-op.
     * If $key contains a colon (e.g. "role:admin"), the part after
     * the colon is passed as a constructor argument to the middleware.
     *
     * @param  string|null $key  A key from MAP (optionally with :param), or null to skip.
     * @return void
     *
     * @throws \Exception If the key doesn't exist in MAP.
     */
    public static function resolve($key): void
    {
        if (!$key) {
            return;
        }

        // Split "role:admin" into name="role", param="admin".
        // For simple keys like "auth", param will be null.
        $parts = explode(":", $key, 2);
        $name = $parts[0];
        $param = $parts[1] ?? null;

        $middleware_class = static::MAP[$name] ?? false;

        if (!$middleware_class) {
            throw new \Exception(
                "No matching middleware found for key '{$name}'.",
            );
        }

        // Instantiate with or without the parameter, then run handle().
        $middleware =
            $param !== null
                ? new $middleware_class($param)
                : new $middleware_class();
        $middleware->handle();
    }
}
