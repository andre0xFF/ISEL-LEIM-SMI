<?php

require "../vendor/autoload.php";

use Smi\Rooted\Core\Router;

session_start();

//$a = 1;
//print var_dump($a);
//return;

$router = new Router();

$uri = isset($_SERVER["REQUEST_URI"]) ? parse_url($_SERVER["REQUEST_URI"])["path"] : "/";

$method = isset($_POST["_method"]) ? stripslashes($_POST["_method"]) : $_SERVER["REQUEST_METHOD"];

try {
    $router->route($uri, $method);
} catch (ValidationException $exception) {
    Session::flash("errors", $exception->errors);
    Session::flash("old", $exception->old);

    redirect($router->previousUrl());
}
