<?php

namespace Core\Middleware;

/**
 * Restricts access to visitors who are NOT logged in.
 *
 * Applied to routes with ->only("guest"). If the visitor is already
 * authenticated, they are redirected to the home page. Useful for
 * pages like login and registration that shouldn't be accessible
 * once you're signed in.
 */
class Guest
{
    /**
     * Allow the request if no user is logged in, otherwise redirect.
     *
     * @return void
     */
    public function handle(): void
    {
        if ($_SESSION["user"] ?? false) {
            redirect("/");
        }
    }
}
