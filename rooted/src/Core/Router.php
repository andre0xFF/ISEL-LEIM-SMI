<?php

namespace Smi\Rooted\Core;

/**
 * Class Router. Responsible for routing requests to the appropriate controller.
 */
class Router
{
    protected array $routes = [];

    /**
     * Add a new route.
     */
    public function addRoute($method, $uri, $controller, Middleware $middleware = null): void
    {
        $this->routes[] = [
            "uri" => $uri,
            "controller" => $controller,
            "method" => $method,
            "middleware" => $middleware
        ];
    }

    /**
     * Register a new GET route.
     */
    public function get($uri, $controller, Middleware $middleware = null): void
    {
        $this->addRoute("GET", $uri, $controller, $middleware);
    }

    /**
     * Register a new POST route.
     */
    public function post($uri, $controller, Middleware $middleware = null): void
    {
        $this->addRoute("POST", $uri, $controller, $middleware);
    }

    /**
     * Register a new DELETE route.
     */
    public function delete($uri, $controller, Middleware $middleware = null): void
    {
        $this->addRoute("DELETE", $uri, $controller, $middleware);
    }

    /**
     * Register a new PATCH route.
     */
    public function patch($uri, $controller, Middleware $middleware = null): void
    {
        $this->addRoute("PATCH", $uri, $controller, $middleware);
    }

    /**
     * Register a new PUT route.
     */
    public function put($uri, $controller, Middleware $middleware = null): void
    {
        $this->addRoute("PUT", $uri, $controller, $middleware);
    }

    /**
     * Abort the request with a given status code.
     */
    protected function abort($code = 404): void
    {
        http_response_code($code);

        render("../src/Views/errors/404.php");

        // die();
    }

    /**
     * Route the request to the appropriate controller.
     */
    public function route($uri, $method): void
    {
        foreach ($this->routes as $route) {
            if ($route["uri"] === $uri && $route["method"] === strtoupper($method)) {
                $route["middleware"]?->handle();
                $route["controller"]->handle();
            }
        }

        $this->abort();
    }

    /**
     * Get the previous URL.
     */
    public function previousUrl(): mixed
    {
        return filter_input(INPUT_SERVER, "HTTP_REFERER", FILTER_SANITIZE_STRING);
        // return $_SERVER["HTTP_REFERER"];
    }
}
