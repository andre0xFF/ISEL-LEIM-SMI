<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Core\Mailer;

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

$errors = [];

if (!Validator::email($email)) {
    $errors["email"] = "Please provide a valid email address.";
}

if (!Validator::string($password, 7, 255)) {
    $errors["password"] = "Please provide a password of at least 7 characters.";
} elseif (!Validator::strongPassword($password)) {
    $errors["password"] = "Password must include at least one letter, one number, and one special character.";
}

if (!empty($errors)) {
    return view("registration/create.view.php", [
        "heading" => "Register",
        "errors" => $errors,
    ]);
}

$db = App::resolve(Database::class);

$user = $db
    ->query("SELECT * FROM users WHERE email = :email", [
        "email" => $email,
    ])
    ->find();

if ($user) {
    return view("registration/create.view.php", [
        "heading" => "Register",
        "errors" => [
            "email" => "A user with that email address already exists.",
        ],
    ]);
}

$db->query("INSERT INTO users(email, password) VALUES(:email, :password)", [
    "email" => $email,
    "password" => password_hash($password, PASSWORD_BCRYPT),
]);

$userId = (int) $db->lastInsertId();

$token = bin2hex(random_bytes(32));
$tokenHash = hash("sha256", $token);
$expiresAt = date("Y-m-d H:i:s", strtotime("+24 hours"));

$db->query(
    "INSERT INTO email_verifications(user_id, token_hash, expires_at) VALUES(:user_id, :token_hash, :expires_at)",
    [
        "user_id" => $userId,
        "token_hash" => $tokenHash,
        "expires_at" => $expiresAt,
    ]
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
    htmlspecialchars($verifyUrl, ENT_QUOTES, "UTF-8") .
    '">Verify your account</a></p>
    <p>This link expires in 24 hours.</p>
';

$sendSucceeded = Mailer::send(
    $email,
    "Rooted - Verify your email",
    $plainBody,
    $htmlBody,
);

if (!$sendSucceeded) {
    $db->query("DELETE FROM email_verifications WHERE user_id = :user_id", [
        "user_id" => $userId,
    ]);

    $db->query("DELETE FROM users WHERE id = :id", [
        "id" => $userId,
    ]);

    return view("registration/create.view.php", [
        "heading" => "Register",
        "errors" => [
            "email" => "We could not send the verification email right now. Please try again.",
        ],
    ]);
}

$_SESSION["_flash"]["success"] = "Check your email for the verification link.";

redirect("/login");