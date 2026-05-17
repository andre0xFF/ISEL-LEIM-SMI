<?php

use Core\Authenticator;

$code = trim($_POST["code"] ?? "");

if ($code === "") {
    $_SESSION["_flash"]["errors"] = [
        "code" => "Please enter the verification code.",
    ];
    return redirect("/verify");
}

$authenticator = new Authenticator();
$valid = $authenticator->verifyTwoFactorCode($_SESSION["user"]["id"], $code);

if (!$valid) {
    $_SESSION["_flash"]["errors"] = [
        "code" => "Invalid or expired code. Please try again.",
    ];
    return redirect("/verify");
}

// Mark the session as fully verified.
$_SESSION["user"]["2fa_verified"] = true;

redirect("/");
