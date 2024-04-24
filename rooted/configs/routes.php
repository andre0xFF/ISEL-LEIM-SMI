<?php

use Smi\Rooted\Controllers\AuthenticationController;
use Smi\Rooted\Controllers\IndexController;
use Smi\Rooted\Controllers\PlantController;
use Smi\Rooted\Controllers\UserController;
use Smi\Rooted\Core\Router;

function addRoutes(Router $router): void
{
    $router->get("/", IndexController::class, "getIndex");

    $router->get("/users/{id}", UserController::class, "getUser");
    $router->get("/users", UserController::class, "getUsers");
    $router->post("/users", UserController::class, "createUser");
    $router->put("/users/{id}", UserController::class, "updateUser");
    $router->delete("/users/{id}", UserController::class, "deleteUser");

    $router->post("/sessions", AuthenticationController::class, "createSession");
    $router->delete("/sessions", AuthenticationController::class, "deleteSession");
    $router->post("/registrations", AuthenticationController::class, "createRegistration");
    $router->get("/verifications", AuthenticationController::class, "getVerify");
    $router->post("/verifications", AuthenticationController::class, "createVerification");
    $router->post("/resend-2fa", AuthenticationController::class, "resend2FACode");

    $router->get("/plants/{id}", PlantController::class, "getPlant");
    $router->get("/plants", PlantController::class, "getPlants");
    $router->post("/plants", PlantController::class, "createPlant");
    $router->put("/plants/{id}", PlantController::class, "updatePlant");
    $router->delete("/plants/{id}", PlantController::class, "deletePlant");
}
