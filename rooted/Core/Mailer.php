<?php

namespace Core;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

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
    public static function send(string $to, string $subject, string $body, ?string $htmlBody = null): bool
    {
        // Always log — this is the reliable way to see emails in development.
        static::log($to, $subject, $body);

        $db = App::resolve(Database::class);

        $rows = $db->query("SELECT `key`, value FROM settings")->get();

        $settings = [];

        foreach ($rows as $row){
            $settings[$row["key"]] = $row["value"];
        }

        $host = $settings["smtp_host"] ?? "";
        $port = (int) ($settings["smtp_port"] ?? 587);
        $username = $settings["smtp_user"] ?? "";
        $password = $settings["smtp_password"] ?? "";
        $fromAddress = $settings["smtp_from_address"] ?? "noreply@rooted.local";
        $fromName = $settings["smtp_from_name"] ?? "Rooted";

        if($host === "" || $username === "" || $password === ""){
            return false;
        }

        $mail = new PHPMailer(true);

        try{

            $mail->isSMTP();
            $mail->Host = $host;
            $mail->Port = $port;
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $password;

            if ($port === 465) {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            $mail->CharSet = "UTF-8";

            $mail->setFrom($fromAddress, $fromName);
            $mail->addAddress($to);

            if($htmlBody !== null){
                $mail->isHTML(true);
                $mail->Body = $htmlBody;
                $mail->AltBody = $body;

            }else{
                $mail->Body = $body;
                $mail->AltBody = $body;
            }

            $mail->Subject = $subject;

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }

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
