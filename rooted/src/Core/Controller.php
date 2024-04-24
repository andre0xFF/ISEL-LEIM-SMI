<?php

namespace Smi\Rooted\Core;

interface Controller
{
    public function handle(string $uri, string $method): void;
}
