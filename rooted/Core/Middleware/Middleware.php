<?php

namespace Core\Middleware;

/**
 * Registry that maps short string keys to middleware classes.
 *
 * Middleware runs before a controller to guard access. Routes opt in
 * by chaining ->only("auth") or ->only("guest"), and the Router calls
 * Middleware::resolve() with that key before requiring the controller file.
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
    ];

    /**
     * Look up and run the middleware for the given key.
     *
     * If $key is null (route has no middleware), this is a no-op.
     *
     * @param  string|null $key  A key from MAP, or null to skip.
     * @return void
     *
     * @throws \Exception If the key doesn't exist in MAP.
     */
    public static function resolve($key): void
    {
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if (!$middleware) {
            throw new \Exception(
                "No matching middleware found for key '{$key}'.",
            );
        }

        // Instantiate the middleware class and call handle().
        // handle() either allows the request to proceed (by returning)
        // or blocks it (by redirecting and calling exit()).
        new $middleware()->handle();
    }
}
