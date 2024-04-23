<?php

namespace Smi\Rooted\Core;

function redirect($path)
{
    header("location: {$path}");
    // exit();
}

function render($templatePath, $variables = []): void
{
    extract($variables);

    require $templatePath;
}

function getMethod()
{
    return $_POST["_method"] ?? $_SERVER["REQUEST_METHOD"];
}

function getUri()
{
    return isset($_SERVER["REQUEST_URI"]) ? parse_url($_SERVER["REQUEST_URI"])["path"] : "/";
}
