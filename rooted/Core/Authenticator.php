<?php

namespace Core;

/**
 * Handles user authentication — login attempts, session creation,
 * two-factor verification, and logout/session destruction.
 */
class Authenticator
{
    protected ?string $lastAttemptFailure = null;
    /**
     * Verify credentials and log the user in if they match.
     *
     * @param  string $email
     * @param  string $password  Plain-text password (checked against the stored hash).
     * @return bool              True if login succeeded, false otherwise.
     */
    public function attempt($email, $password): bool
    {
        $this->lastAttemptFailure = null;

        $user = App::resolve(Database::class)
            ->query("SELECT * FROM users WHERE email = :email", [
                "email" => $email,
            ])
            ->find();

        if(!$user){
            $this->lastAttemptFailure = "invalid_credentials";
            return false;
        }

        if(!password_verify($password, $user["password"])){
            $this->lastAttemptFailure = "invalid_credentials";
            return false;
        }

        if(!(int) $user["email_verified"]){
            $this->lastAttemptFailure = "email_unverified";
            return false;
        }

        $this->login($user);

        return true;
    }


    public function lastAttemptFailure(): ?string{
        return $this->lastAttemptFailure;
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
    public function sendTwoFactorCode(int $userId, string $email): bool
    {
        $code = str_pad((string) random_int(0, 999999), 6, "0", STR_PAD_LEFT);
        $expiresAt = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        $sendSucceeded = Mailer::send(
            $email,
            "Rooted — Your verification code",
            "Your verification code is: {$code}\n\nThis code expires in 10 minutes.",
        );

        if(!$sendSucceeded){
            return false;
        }


        App::resolve(Database::class)->query(
            "UPDATE users SET two_factor_code = :code, two_factor_expires_at = :expires WHERE id = :id",
            [
                "code" => $code,
                "expires" => $expiresAt,
                "id" => $userId,
            ],
        );

    return true;

    }

    /**
     * Verify a submitted 2FA code against the database.
     *
     * On success the code is cleared from the database.
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
            "UPDATE users SET two_factor_code = NULL, two_factor_expires_at = NULL WHERE id = :id",
            ["id" => $userId],
        );

        return true;
    }
}
