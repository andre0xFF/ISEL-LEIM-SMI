<?php

use Core\Authenticator;
use Http\Forms\LoginForm;

$form = LoginForm::validate(
    $attributes = [
        "email" => $_POST["email"],
        "password" => $_POST["password"],
    ],
);

$authenticator = new Authenticator();
$signedIn = $authenticator->attempt(
    $attributes["email"],
    $attributes["password"],
);

if (!$signedIn) {
    $form
        ->error(
            "email",
            "No matching account found for that email address and password.",
        )
        ->throw();
}

// Credentials are valid — now start the 2FA flow.
// Generate a code, email it, and redirect to the verification page.
$authenticator->sendTwoFactorCode(
    $_SESSION["user"]["id"],
    $_SESSION["user"]["email"],
);

redirect("/verify");
