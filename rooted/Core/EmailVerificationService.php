<?php

namespace Core;

class EmailVerificationService
{

    public static function sendForUser(int $userId, string $email): bool
    {

        $db = App::resolve(Database::class);

        $token = bin2hex(random_bytes(32));

        $tokenHash = hash("sha256", $token);

        $expiresAt = date("Y-m-d H:i:s", strtotime("+24 hours"));

        $db->query(
            "INSERT INTO email_verifications (user_id, token_hash, expires_at, consumed_at)
             VALUES (:user_id, :token_hash, :expires_at, NULL)
             ON DUPLICATE KEY UPDATE
                 token_hash = :token_hash_update,
                 expires_at = :expires_at_update,
                 consumed_at = NULL",
            [
                "user_id" => $userId,
                "token_hash" => $tokenHash,
                "expires_at" => $expiresAt,
                "token_hash_update" => $tokenHash,
                "expires_at_update" => $expiresAt,
            ],
        );

        $appUrlSetting = $db
            ->query("SELECT value FROM settings WHERE `key` = 'app_url'")
            ->find();

        $appUrl = rtrim($appUrlSetting["value"] ?? "http://localhost:8080", "/");

        $verifyUrl = $appUrl . "/verify?token=" . urlencode($token);

        $plainBody = "Click the link below to verify your account:\n\n{$verifyUrl}\n\nThis link expires in 24 hours.";

        $htmlBody = '
            <p>Click the link below to verify your account:</p>
            <p><a href="' .
            htmlspecialchars($verifyUrl, ENT_QUOTES, "UTF-8") . '">Verify your account</a></p>
            <p>This link expires in 24 hours.</p>';

        return Mailer::send(
            $email,
            "Rooted - Verify your email",
            $plainBody,
            $htmlBody,
        );


    }


}