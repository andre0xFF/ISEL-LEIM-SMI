<?php

use Core\App;
use Core\Database;
use Core\EmailVerificationService;
use Core\Validator;


$email = trim($_POST["email"] ?? "");


if (!Validator::email($email)) {

    $_SESSION["_flash"]["errors"] = ["email" => "Please provide a valid email address.",];

    return redirect("/login");

}

$db = App::resolve(Database::class);

$user = $db->query("SELECT id, email, email_verified FROM users WHERE email = :email", [
    "email" => $email,
])->find();

if ($user && !(int)$user["email_verified"]) {
    $sendSucceeded = EmailVerificationService::sendForUser(
        (int)$user["id"],
        $user["email"],
    );

    if (!$sendSucceeded) {
        $_SESSION["_flash"]["errors"] = [
            "email" => "We could not send the verification email right now. Please try again.",
        ];

        return redirect("/login");
    }
}

$_SESSION["_flash"]["success"] = "If that account still needs verification, a new link has been sent.";

redirect("/login");
