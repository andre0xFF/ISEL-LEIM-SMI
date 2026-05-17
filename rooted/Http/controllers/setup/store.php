<?php

use Core\App;
use Core\Authenticator;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

// ── Prevent re-execution if an admin already exists ─────────────────

$admin = $db->query("SELECT COUNT(*) as cnt FROM users WHERE role = 'admin'")->find();

if ($admin && (int) $admin["cnt"] > 0) {
    redirect("/");
}

// ── Read POST data ──────────────────────────────────────────────────

$email         = trim($_POST["email"] ?? "");
$password      = $_POST["password"] ?? "";
$smtpHost      = trim($_POST["smtp_host"] ?? "");
$smtpPort      = trim($_POST["smtp_port"] ?? "");
$smtpUser      = trim($_POST["smtp_user"] ?? "");
$smtpPassword  = $_POST["smtp_password"] ?? "";

// ── Validate ────────────────────────────────────────────────────────

$errors = [];

if (!Validator::email($email)) {
    $errors["email"] = "A valid email address is required.";
}

if (!Validator::string($password, 7)) {
    $errors["password"] = "Password must be at least 7 characters.";
}

if (!empty($errors)) {
    return view("setup/index.view.php", [
        "heading" => "Setup — Rooted",
        "errors" => $errors,
    ]);
}

// ── Create admin account ────────────────────────────────────────────

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$db->query(
    "INSERT INTO users (email, password, role, email_verified)
     VALUES (:email, :password, :role, :verified)",
    [
        "email"    => $email,
        "password" => $hashedPassword,
        "role"     => "admin",
        "verified" => 1,
    ],
);

$userId = (int) $db->lastInsertId();

// ── Save SMTP settings (UPSERT) ────────────────────────────────────

$settingsMap = [
    "smtp_host"     => $smtpHost,
    "smtp_port"     => $smtpPort,
    "smtp_user"     => $smtpUser,
    "smtp_password" => $smtpPassword,
];

foreach ($settingsMap as $key => $value) {
    $db->query(
        "INSERT INTO settings (`key`, `value`) VALUES (:key, :value)
         ON DUPLICATE KEY UPDATE `value` = :value2",
        [
            "key"    => $key,
            "value"  => $value,
            "value2" => $value,
        ],
    );
}

// ── Auto-login the new admin ────────────────────────────────────────

$authenticator = new Authenticator();
$authenticator->login([
    "id"    => $userId,
    "email" => $email,
    "role"  => "admin",
]);

// Mark 2FA as verified so setup doesn't require a code
$_SESSION["user"]["2fa_verified"] = true;

redirect("/");
