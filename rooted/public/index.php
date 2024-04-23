<?php

require "../vendor/autoload.php";

use Smi\Rooted\Controllers\IndexController;
use Smi\Rooted\Core\Router;
use function Smi\Rooted\Core\getMethod;
use function Smi\Rooted\Core\getUri;

function addRoutes(Router $router): void
{
    $router->get("/", new IndexController());
}

session_start();

$router = new Router();
$uri = getUri();
$method = getMethod();

addRoutes($router);

try {
    $router->route($uri, $method);
} catch (ValidationException $exception) {
    Session::flash("errors", $exception->errors);
    Session::flash("old", $exception->old);

    redirect($router->previousUrl());
}
