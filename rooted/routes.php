<?php

$router->get("/", "index.php");

$router->get("/plants", "plants/index.php")->only("auth");
$router->get("/plant", "plants/show.php")->only("auth");
$router->delete("/plant", "plants/destroy.php")->only("auth");
$router->get("/plant/edit", "plants/edit.php")->only("auth");
$router->patch("/plant", "plants/update.php")->only("auth");
$router->get("/plants/create", "plants/create.php")->only("auth");
$router->post("/plants", "plants/store.php")->only("auth");

$router->get("/users", "users/index.php")->only("auth");
$router->get("/user", "users/show.php")->only("auth");
$router->post("/users", "users/store.php")->only("auth");
$router->put("/user", "users/update.php")->only("auth");
$router->delete("/user", "users/destroy.php")->only("auth");

$router->get("/register", "registration/create.php")->only("guest");
$router->post("/register", "registration/store.php")->only("guest");

$router->get("/login", "session/create.php")->only("guest");
$router->post("/session", "session/store.php")->only("guest");
$router->delete("/session", "session/destroy.php")->only("auth");

$router->get("/verify", "verification/show.php")->only("auth");
$router->post("/verify", "verification/store.php")->only("auth");
$router->post("/resend-2fa", "verification/resend.php")->only("auth");
