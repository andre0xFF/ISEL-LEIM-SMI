<?php

/**
 * Route definitions — maps URL + HTTP method pairs to controller files.
 *
 * Returns a function that receives the Router instance. This avoids
 * relying on PHP's implicit scope sharing through require.
 */

use Core\Router;

return function (Router $router) {
    $router->get("/", "index.php");

    // Plant routes — browsing is for any authenticated user, management for moderators
    $router->get("/plants", "plants/index.php")->only("auth");
    $router->get("/plant", "plants/show.php")->only("auth");
    $router
        ->get("/plants/create", "plants/create.php")
        ->only("auth", "role:moderator");
    $router
        ->post("/plants", "plants/store.php")
        ->only("auth", "role:moderator");
    $router
        ->get("/plant/edit", "plants/edit.php")
        ->only("auth", "role:moderator");
    $router
        ->patch("/plant", "plants/update.php")
        ->only("auth", "role:moderator");
    $router
        ->delete("/plant", "plants/destroy.php")
        ->only("auth", "role:moderator");

    // User management — admin only
    $router->get("/users", "users/index.php")->only("auth", "role:admin");
    $router->get("/user", "users/show.php")->only("auth", "role:admin");
    $router->post("/users", "users/store.php")->only("auth", "role:admin");
    $router->put("/user", "users/update.php")->only("auth", "role:admin");
    $router->delete("/user", "users/destroy.php")->only("auth", "role:admin");

    // Registration — guests only
    $router->get("/register", "registration/create.php")->only("guest");
    $router->post("/register", "registration/store.php")->only("guest");

    // Session (login/logout)
    $router->get("/login", "session/create.php")->only("guest");
    $router->post("/session", "session/store.php")->only("guest");
    $router->delete("/session", "session/destroy.php")->only("auth");

    // 2FA Verification
    $router->get("/verify", "verification/show.php")->only("auth");
    $router->post("/verify", "verification/store.php")->only("auth");
    $router->post("/resend-2fa", "verification/resend.php")->only("auth");
};
