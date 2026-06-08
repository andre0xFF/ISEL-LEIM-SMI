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
    if ($authenticator->lastAttemptFailure() === "email_unverified") {
        $_SESSION["_flash"]["resend_verification_email"] = $attributes["email"];

        $form
            ->error("email", "Please verify your email before logging in.")
            ->throw();
    }

    $form
        ->error(
            "email",
            "No matching account found for that email address and password.",
        )
        ->throw();
}

$sendSucced = $authenticator->sendTwoFactorCode(
    $_SESSION["user"]["id"],
    $_SESSION["user"]["email"],
);

if (!$sendSucced) {
    $authenticator->logout(false);

    $form
        ->error(
            "email",
            "We could not send the verification code right now. Please try again.",
        )
        ->throw();
}

redirect("/two-factor");
