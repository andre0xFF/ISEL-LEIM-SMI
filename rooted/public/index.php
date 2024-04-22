<?php

require __DIR__ . '/../vendor/autoload.php';

use Smi\Rooted\Core\Router;

const BASE_PATH = __DIR__ . '/../';

session_start();

$router = new Router();
