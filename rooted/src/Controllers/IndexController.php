<?php

namespace Smi\Rooted\Controllers;

use Smi\Rooted\Core\Controller;
use function Smi\Rooted\Core\render;

class IndexController implements Controller
{
    public function handle(string $uri, string $method): void
    {
        if ($method == "GET" && $uri == "/" || $uri == "/index") {
            $this->getIndex();
        }
    }

    public function getIndex(): void
    {
        render("../src/Views/index.php", ["heading" => "Home",]);
    }
}
