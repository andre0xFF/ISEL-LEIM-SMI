<?php

namespace Core\Middleware;

/**
 * Requires the user to have completed 2FA verification.
 *
 * If the session flag '2fa_verified' is not true, the user is
 * redirected to the verification page.
 */
class Verified
{
    public function handle(): void
    {
        if (!($_SESSION["user"]["2fa_verified"] ?? false)) {
            redirect("/verify");
        }
    }
}
