<?php

namespace Smi\Rooted\Core;

function redirect($path)
{
    header("location: {$path}");
    // exit();
}

function render($templatePath, $variables = []): void
{
    if (!empty($variables)) {
        extract($variables);
    }

    require $templatePath;
}

function getMethod()
{
    // return filter_input_array(INPUT_POST, ['_method']) ?? filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    return $_POST["_method"] ?? $_SERVER["REQUEST_METHOD"];
}

function getUri()
{
    return filter_input(INPUT_SERVER, 'REQUEST_URI') ?? "/";
    // return isset($_SERVER["REQUEST_URI"]) ? parse_url($_SERVER["REQUEST_URI"])["path"] : "/";
}

function uriIs(string $value): bool
{
    return getUri() === $value;
}
