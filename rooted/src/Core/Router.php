<?php

namespace Smi\Rooted\Core;

class Router
{
    protected $routes = [];

    public function addRoute($method, $uri, $controller, Middleware $middleware = null)
    {
        $this->routes[] = [
            "uri" => $uri,
            "controller" => $controller,
            "method" => $method,
            "middleware" => $middleware
        ];
    }

    public function get($uri, $controller, Middleware $middleware = null)
    {
        $this->addRoute("GET", $uri, $controller, $middleware);
    }

    public function post($uri, $controller, Middleware $middleware = null)
    {
        $this->addRoute("POST", $uri, $controller, $middleware);
    }

    public function delete($uri, $controller, Middleware $middleware = null)
    {
        $this->addRoute("DELETE", $uri, $controller, $middleware);
    }

    public function patch($uri, $controller, Middleware $middleware = null)
    {
        $this->addRoute("PATCH", $uri, $controller, $middleware);
    }

    public function put($uri, $controller, Middleware $middleware = null)
    {
        $this->addRoute("PUT", $uri, $controller, $middleware);
    }

    protected function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.php");

        die();
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route["uri"] === $uri && $route["method"] === strtoupper($method)) {
                if ($route["middleware"] !== null) {
                    $route["middleware"]->handle();
                }

                return require base_path("Http/controllers/" . $route["controller"]);
            }
        }

        $this->abort();
    }

    public function previousUrl()
    {
        return $_SERVER["HTTP_REFERER"];
    }
}
