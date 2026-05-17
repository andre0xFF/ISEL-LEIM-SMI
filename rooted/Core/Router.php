<?php

namespace Core;

use Core\Middleware\Middleware;

/**
 * Maps URL + HTTP method pairs to controller files and dispatches requests.
 *
 * Routes are registered in routes.php using the convenience methods
 * (get, post, delete, patch, put), which build up an internal array
 * of route definitions. When a request comes in, route() walks that
 * array looking for a match, runs any middleware, and then requires
 * the corresponding controller file.
 *
 * Example:
 *   $router->get("/plants", "plants/index.php")->only("auth");
 *   // GET /plants → Http/controllers/plants/index.php (authenticated users only)
 */
class Router
{
    /**
     * @var array<int, array{uri: string, controller: string, method: string, middleware: string|null}>
     *   Each entry holds the URI, controller file path, HTTP method, and optional middleware key.
     */
    protected $routes = [];

    /**
     * Register a route for the given HTTP method.
     *
     * This is the low-level method — prefer the convenience methods
     * (get, post, delete, patch, put) which call this internally.
     *
     * @param  string $method      HTTP method (GET, POST, DELETE, etc.).
     * @param  string $uri         The URL path to match (e.g. "/plants").
     * @param  string $controller  Path to the controller file, relative to Http/controllers/.
     * @return $this               Returns itself so ->only() can be chained.
     */
    public function add($method, $uri, $controller): self
    {
        $this->routes[] = [
            "uri" => $uri,
            "controller" => $controller,
            "method" => $method,
            "middleware" => [],
        ];

        return $this;
    }

    /**
     * Register a GET route.
     *
     * @param  string $uri
     * @param  string $controller
     * @return $this
     */
    public function get($uri, $controller): self
    {
        return $this->add("GET", $uri, $controller);
    }

    /**
     * Register a POST route.
     *
     * @param  string $uri
     * @param  string $controller
     * @return $this
     */
    public function post($uri, $controller): self
    {
        return $this->add("POST", $uri, $controller);
    }

    /**
     * Register a DELETE route.
     *
     * @param  string $uri
     * @param  string $controller
     * @return $this
     */
    public function delete($uri, $controller): self
    {
        return $this->add("DELETE", $uri, $controller);
    }

    /**
     * Register a PATCH route.
     *
     * @param  string $uri
     * @param  string $controller
     * @return $this
     */
    public function patch($uri, $controller): self
    {
        return $this->add("PATCH", $uri, $controller);
    }

    /**
     * Register a PUT route.
     *
     * @param  string $uri
     * @param  string $controller
     * @return $this
     */
    public function put($uri, $controller): self
    {
        return $this->add("PUT", $uri, $controller);
    }

    /**
     * Attach one or more middlewares to the most recently registered route.
     *
     * This is designed to be chained after a route method:
     *   $router->get("/plants", "plants/index.php")->only("auth");
     *   $router->get("/users", "users/index.php")->only("auth", "admin");
     *
     * @param  string ...$keys  Middleware keys defined in Middleware::MAP.
     * @return $this
     */
    public function only(string ...$keys): self
    {
        $this->routes[array_key_last($this->routes)]["middleware"] = $keys;

        return $this;
    }

    /**
     * Dispatch an incoming request to the matching controller.
     *
     * Walks the registered routes looking for a URI + method match.
     * If found, runs the route's middleware (if any) and then requires
     * the controller file. If no route matches, responds with a 404.
     *
     * @param  string $uri     The request path (e.g. "/plants").
     * @param  string $method  The HTTP method (e.g. "GET", "POST").
     * @return mixed
     */
    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if (
                $route["uri"] === $uri &&
                $route["method"] === strtoupper($method)
            ) {
                foreach ($route["middleware"] as $middleware) {
                    Middleware::resolve($middleware);
                }

                return require base_path(
                    "Http/controllers/" . $route["controller"],
                );
            }
        }

        $this->abort();
    }

    /**
     * Get the URL the user came from (the Referer header).
     *
     * Used to redirect back to the previous page after validation failures.
     *
     * @return string
     */
    public function previousUrl(): string
    {
        return $_SERVER["HTTP_REFERER"];
    }

    /**
     * Halt execution and render an error page.
     *
     * @param  int $code  HTTP status code (default: NOT_FOUND_ERR).
     * @return never
     */
    protected function abort($code = Response . NOT_FOUND_ERR): never
    {
        // Delegate to the global abort() helper in Core/functions.php
        // to avoid duplicating the same logic.
        abort($code);
    }
}
