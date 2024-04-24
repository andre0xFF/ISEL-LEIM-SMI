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
    public function addRoute(string $http_method, string $uri, $controller_class, string $controller_method = null, Middleware $middleware = null): void
    {
        $this->routes[] = [
            "uri" => strtoupper($uri),
            "http_method" => $http_method,
            "controller_class" => $controller_class,
            "controller_method" => $controller_method,
            "middleware" => $middleware
        ];
    }

    /**
     * Register a new GET route.
     */
    public function get(string $uri, $controller_class, string $controller_method = null, Middleware $middleware = null): void
    {
        $this->addRoute("GET", $uri, $controller_class, $controller_method, $middleware);
    }

    /**
     * Register a new POST route.
     */
    public function post(string $uri, callable $controller_class, string $controller_method = null, Middleware $middleware = null): void
    {
        $this->addRoute("POST", $uri, $controller_class, $controller_method, $middleware);
    }

    /**
     * Register a new DELETE route.
     */
    public function delete(string $uri, callable $controller_class, string $controller_method = null, Middleware $middleware = null): void
    {
        $this->addRoute("DELETE", $uri, $controller_class, $controller_method, $middleware);
    }

    /**
     * Register a new PATCH route.
     */
    public function patch(string $uri, callable $controller_class, string $controller_method = null, Middleware $middleware = null): void
    {
        $this->addRoute("PATCH", $uri, $controller_class, $controller_method, $middleware);
    }

    /**
     * Register a new PUT route.
     */
    public function put(string $uri, callable $controller_class, string $controller_method = null, Middleware $middleware = null): void
    {
        $this->addRoute("PUT", $uri, $controller_class, $controller_method, $middleware);
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
            if ($route["uri"] === $uri && $route["http_method"] === strtoupper($method)) {
                $route["middleware"]?->handle();

                $controller = new $route["controller_class"]();

                // If the route has a specific controller method, call it. Otherwise, call the handle method on the controller.
                if (isset($route["controller_method"])) {
                    $method = $route["controller_method"];

                    $controller->$method();
                } else {
                    $controller->handle($uri, $method);
                }
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
