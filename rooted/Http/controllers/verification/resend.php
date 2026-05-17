<?php

use Core\Authenticator;

$authenticator = new Authenticator();
$authenticator->sendTwoFactorCode(
    $_SESSION["user"]["id"],
    $_SESSION["user"]["email"],
);

$_SESSION["_flash"]["success"] = "A new code has been sent to your email.";

redirect("/verify");
