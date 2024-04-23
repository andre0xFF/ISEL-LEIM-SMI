<?php

namespace Smi\Rooted\Controllers;

use Smi\Rooted\Core\Controller;
use function Smi\Rooted\Core\render;

class IndexController implements Controller
{
    public function handle(): void
    {
        render("../src/Views/index.php", ["heading" => "Home",]);
    }
}
