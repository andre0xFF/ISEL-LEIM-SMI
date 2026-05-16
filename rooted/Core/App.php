<?php

namespace Core;

/**
 * Global access point to the dependency injection container.
 *
 * Rather than passing the Container instance through every function call,
 * this class stores it as a static property so any file in the application
 * can retrieve shared services with:
 *
 *   $db = App::resolve(Database::class);
 *
 * The container is set once during bootstrap (see bootstrap.php).
 */
class App
{
    /** @var Container The application's service container. */
    protected static $container;

    /**
     * Store the container instance for global access.
     *
     * @param  Container $container
     * @return void
     */
    public static function setContainer($container): void
    {
        static::$container = $container;
    }

    /**
     * Get the container instance.
     *
     * @return Container
     */
    public static function container(): Container
    {
        return static::$container;
    }

    /**
     * Shortcut to register a binding on the container.
     *
     * @param  string   $key       The service key (typically a class name).
     * @param  callable $resolver  Factory function that creates the instance.
     * @return void
     */
    public static function bind($key, $resolver): void
    {
        static::container()->bind($key, $resolver);
    }

    /**
     * Shortcut to resolve a service from the container.
     *
     * @param  string $key  The service key that was used in bind().
     * @return mixed        The instance returned by the factory function.
     */
    public static function resolve($key)
    {
        return static::container()->resolve($key);
    }
}
