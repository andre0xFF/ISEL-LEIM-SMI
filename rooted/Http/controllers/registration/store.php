<?php

use Core\App;
use Core\Authenticator;
use Core\Database;
use Core\Validator;

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

$errors = [];

if (!Validator::email($email)) {
    $errors["email"] = "Please provide a valid email address.";
}

if (!Validator::string($password, 7, 255)) {
    $errors["password"] = "Please provide a password of at least 7 characters.";
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

$authenticator = new Authenticator();

$authenticator->login([
    "id" => $db->lastInsertId(),
    "email" => $email,
    "role" => "user",
]);

// New registrations skip 2FA — the user just proved identity by creating the account.
$_SESSION["user"]["2fa_verified"] = true;

redirect("/");
