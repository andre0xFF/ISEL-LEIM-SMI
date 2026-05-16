<?php

namespace Core;

/**
 * Handles user authentication — login attempts, session creation,
 * and logout/session destruction.
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
            // password_verify checks a plain-text password against a bcrypt
            // hash (the format stored in the database by password_hash()).
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
     * Only `id` and `email` are kept — never store the password hash
     * in the session.
     *
     * @param  array $user  A database row with at least 'id' and 'email' keys.
     * @return void
     */
    public function login($user): void
    {
        $_SESSION["user"] = [
            "id" => $user["id"],
            "email" => $user["email"],
        ];

        // Generate a new session ID to prevent session fixation attacks.
        // An attacker who knew the old ID can no longer hijack the session.
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
}
