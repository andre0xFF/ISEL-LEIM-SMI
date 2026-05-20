<?php

use Core\Router;

return function (Router $router) {
    $router->get("/", "index.php");

    // Plants — browsing open to everyone, CUD restricted to moderators
    $router->get("/plants", "plants/index.php");
    $router->get("/plant", "plants/show.php");
    $router
        ->get("/plants/create", "plants/create.php")
        ->only("auth", "role:moderator");
    $router->post("/plants", "plants/store.php")->only("auth", "role:moderator");
    $router->get("/plant/edit", "plants/edit.php")->only("auth", "role:moderator");
    $router->patch("/plant", "plants/update.php")->only("auth", "role:moderator");
    $router->delete("/plant", "plants/destroy.php")->only("auth", "role:moderator");

    // Tags
    $router->get("/tags", "tags/index.php")->only("auth");
    $router->get("/tags/create", "tags/create.php")->only("auth", "role:moderator");
    $router->post("/tags", "tags/store.php")->only("auth", "role:moderator");
    $router->get("/tag/edit", "tags/edit.php")->only("auth", "role:moderator");
    $router->patch("/tag", "tags/update.php")->only("auth", "role:moderator");
    $router->delete("/tag", "tags/destroy.php")->only("auth", "role:moderator");

    // Media
    $router->get("/media", "media/serve.php");
    $router
        ->get("/media/batch-upload", "media/batch-upload-form.php")
        ->only("auth", "role:moderator");
    $router
        ->post("/media/batch-upload", "media/batch-upload.php")
        ->only("auth", "role:moderator");
    $router
        ->get("/media/batch-download", "media/batch-download.php")
        ->only("auth", "role:moderator");

    // Subscriptions
    $router->get("/subscriptions", "subscriptions/index.php")->only("auth");
    $router->post("/subscriptions", "subscriptions/store.php")->only("auth");
    $router->delete("/subscription", "subscriptions/destroy.php")->only("auth");

    // Profile
    $router->get("/profile", "profile/edit.php")->only("auth");
    $router->patch("/profile", "profile/update.php")->only("auth");

    // User management — admin only
    $router->get("/users", "users/index.php")->only("auth", "role:admin");
    $router->get("/user", "users/show.php")->only("auth", "role:admin");
    $router->get("/users/create", "users/create.php")->only("auth", "role:admin");
    $router->post("/users", "users/store.php")->only("auth", "role:admin");
    $router->get("/user/edit", "users/edit.php")->only("auth", "role:admin");
    $router->put("/user", "users/update.php")->only("auth", "role:admin");
    $router->delete("/user", "users/destroy.php")->only("auth", "role:admin");

    // Settings — admin only
    $router->get("/settings", "settings/edit.php")->only("auth", "role:admin");
    $router->patch("/settings", "settings/update.php")->only("auth", "role:admin");

    // Registration — guests only
    $router->get("/register", "registration/create.php")->only("guest");
    $router->post("/register", "registration/store.php")->only("guest");

    // Session (login/logout)
    $router->get("/login", "session/create.php")->only("guest");
    $router->post("/session", "session/store.php")->only("guest");
    $router->delete("/session", "session/destroy.php")->only("auth");

    // 2FA Verification
    $router->get("/two-factor", "verification/two_factor/show.php")->only("auth");
    $router->post("/two-factor", "verification/two_factor/store.php")->only("auth");
    $router->post("/resend-2fa", "verification/two_factor/resend.php")->only("auth");

    // Registration email verification
    $router->get("/verify", "verification/email/show.php")->only("guest");

    // RSS feed
    $router->get("/rss", "rss/feed.php");

    // Map
    $router->get("/map", "map/index.php");

    // PlantNet identification
    $router->post("/identify", "identify/store.php")->only("auth", "role:moderator");

    // Setup wizard
    $router->get("/setup", "setup/index.php");
    $router->post("/setup", "setup/store.php");
};
