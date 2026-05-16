<?php

namespace Core;

use Exception;

/**
 * A simple dependency injection container.
 *
 * Instead of creating objects (like a database connection) directly
 * where they're needed, you register a "recipe" (a callable) for how
 * to build them. Later, any part of the application can ask the
 * container to build one on demand with resolve().
 *
 * This keeps configuration in one place (bootstrap.php) and avoids
 * duplicating setup logic across controllers.
 */
class Container
{
    /** @var array<string, callable> Registered factory functions keyed by class name. */
    protected $bindings = [];

    /**
     * Register a factory function for the given key.
     *
     * Example:
     *   $container->bind(Database::class, function () {
     *       return new Database($config, $user, $pass);
     *   });
     *
     * @param  string   $key       Typically a fully-qualified class name (e.g. 'Core\Database').
     * @param  callable $resolver  A function that creates and returns the instance.
     * @return void
     */
    public function bind($key, $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    /**
     * Build and return the instance registered under the given key.
     *
     * @param  string $key  The key that was used in bind().
     * @return mixed        The object returned by the factory function.
     *
     * @throws Exception If no binding exists for the given key.
     */
    public function resolve($key)
    {
        if (!array_key_exists($key, $this->bindings)) {
            throw new Exception("No matching binding found for '{$key}'.");
        }

        // call_user_func invokes the stored callable — this is where the
        // object (e.g. a Database instance) actually gets created.
        $resolver = $this->bindings[$key];

        return call_user_func($resolver);
    }
}
