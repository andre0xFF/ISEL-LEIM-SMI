<?php

namespace Core;

/**
 * Handles user authentication — login attempts, session creation,
 * two-factor verification, and logout/session destruction.
 */
class Authenticator
{
    /**
     * Verify credentials and log the user in if they match.
     *
     * @param  string $email
     * @param  string $password  Plain-text password (checked against the stored hash).
     * @return bool              True if login succeeded, false otherwise.
     */
    public function attempt($email, $password): bool
    {
        $user = App::resolve(Database::class)
            ->query("SELECT * FROM users WHERE email = :email", [
                "email" => $email,
            ])
            ->find();

        if ($user) {
            if (password_verify($password, $user["password"])) {
                $this->login($user);

                return true;
            }
        }

        return false;
    }

    /**
     * Store the user's identity in the session.
     *
     * Only `id`, `email`, and `role` are kept — never store the password
     * hash in the session. The `2fa_verified` flag starts as false and is
     * set to true after the user completes two-factor verification.
     *
     * @param  array $user  A row with at least 'id', 'email', and 'role' keys.
     * @return void
     */
    public function login($user): void
    {
        $_SESSION["user"] = [
            "id" => $user["id"],
            "email" => $user["email"],
            "role" => $user["role"],
            "2fa_verified" => false,
        ];

        session_regenerate_id(true);
    }

    /**
     * Log the user out by destroying the session and its cookie.
     *
     * @return void
     */
    public function logout(): void
    {
        destroy_session();
    }

    // -----------------------------------------------------------------
    //  Two-Factor Authentication (2FA)
    // -----------------------------------------------------------------

    /**
     * Generate a 6-digit code, store it in the database, and email it.
     *
     * @param  int    $userId  The user's ID.
     * @param  string $email   The user's email address.
     * @return void
     */
    public function sendTwoFactorCode(int $userId, string $email): void
    {
        $code = str_pad((string) random_int(0, 999999), 6, "0", STR_PAD_LEFT);
        $expiresAt = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        App::resolve(Database::class)->query(
            "UPDATE users SET two_factor_code = :code, two_factor_expires_at = :expires WHERE id = :id",
            [
                "code" => $code,
                "expires" => $expiresAt,
                "id" => $userId,
            ],
        );

        Mailer::send(
            $email,
            "Rooted — Your verification code",
            "Your verification code is: {$code}\n\nThis code expires in 10 minutes.",
        );
    }

    /**
     * Verify a submitted 2FA code against the database.
     *
     * On success the code is cleared from the database and `email_verified`
     * is set to 1.
     *
     * @param  int    $userId  The user's ID.
     * @param  string $code    The 6-digit code the user submitted.
     * @return bool            True if the code is valid and not expired.
     */
    public function verifyTwoFactorCode(int $userId, string $code): bool
    {
        $db = App::resolve(Database::class);

        $user = $db
            ->query(
                "SELECT two_factor_code, two_factor_expires_at FROM users WHERE id = :id",
                ["id" => $userId],
            )
            ->find();

        if (!$user) {
            return false;
        }

        if ($user["two_factor_code"] !== $code) {
            return false;
        }

        if (strtotime($user["two_factor_expires_at"]) < time()) {
            return false;
        }

        // Code is valid — clear it and mark the email as verified.
        $db->query(
            "UPDATE users SET two_factor_code = NULL, two_factor_expires_at = NULL, email_verified = 1 WHERE id = :id",
            ["id" => $userId],
        );

        return true;
    }
}
