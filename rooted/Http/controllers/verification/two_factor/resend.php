<?php

use Core\Authenticator;

$authenticator = new Authenticator();

$sendSuccess = $authenticator->sendTwoFactorCode(
    $_SESSION["user"]["id"],
    $_SESSION["user"]["email"],
);

if(!$sendSuccess){
    $_SESSION["_flash"]["errors"] = ["code" => "Couldn't send 2FA code, please retry again in a while.",];
    return redirect("/two-factor");

}

$_SESSION["_flash"]["success"] = "A new code has been sent to your email.";

redirect("/two-factor");
