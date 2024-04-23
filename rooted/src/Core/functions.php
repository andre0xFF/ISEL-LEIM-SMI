<?php

namespace Smi\Rooted\Core;

function redirect($path)
{
    header("location: {$path}");
    exit();
}

function render($templatePath, $variables = []): void
{
    extract($variables);

    require $templatePath;
}
