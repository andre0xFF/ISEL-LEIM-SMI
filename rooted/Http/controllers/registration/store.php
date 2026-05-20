<?php

use Core\App;
use Core\Database;
use Core\EmailVerificationService;
use Core\Validator;

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


$sendSucceeded = EmailVerificationService::sendForUser($userId, $email);



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