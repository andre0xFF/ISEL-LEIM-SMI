<?php

namespace Core;

/**
 * Simple email utility.
 *
 * Every email is logged to storage/app/mail.log so that during development
 * (where a real SMTP server may not be available) the contents can still be
 * inspected. If PHP's mail() function is configured, it will also attempt
 * to deliver the message.
 */
class Mailer
{
    /**
     * Send a plain-text email.
     *
     * @param  string $to       Recipient email address.
     * @param  string $subject  Email subject line.
     * @param  string $body     Plain-text body.
     * @return bool             True if mail() accepted the message (or if logging succeeded).
     */
    public static function send(string $to, string $subject, string $body): bool
    {
        // Always log — this is the reliable way to see emails in development.
        static::log($to, $subject, $body);

        // Attempt real delivery. mail() may return false if no MTA is
        // configured, but we don't treat that as a fatal error.
        $headers = implode("\r\n", [
            "From: noreply@rooted.local",
            "Reply-To: noreply@rooted.local",
            "Content-Type: text/plain; charset=UTF-8",
        ]);

        return @mail($to, $subject, $body, $headers);
    }

    /**
     * Append an email to the log file.
     */
    private static function log(string $to, string $subject, string $body): void
    {
        $entry = sprintf(
            "[%s] To: %s | Subject: %s\n%s\n%s\n\n",
            date("Y-m-d H:i:s"),
            $to,
            $subject,
            $body,
            str_repeat("─", 60),
        );

        $path = BASE_PATH . "storage/app/mail.log";
        file_put_contents($path, $entry, FILE_APPEND | LOCK_EX);
    }
}
