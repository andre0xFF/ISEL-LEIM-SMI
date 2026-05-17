<?php

namespace Core\Middleware;

/**
 * Restricts access to logged-in users only.
 *
 * Applied to routes with ->only("auth"). If the visitor is not
 * authenticated, they are redirected to the home page.
 */
class Authenticated
{
    /**
     * Allow the request if a user is logged in, otherwise redirect.
     *
     * @return void
     */
    public function handle(): void
    {
        if (!($_SESSION["user"] ?? false)) {
            redirect("/login");
        }
    }
}
