<?php

use Core\App;
use Core\Authenticator;
use Core\Database;


$rawToken = $_GET["token"] ?? "";

if($rawToken === ""){
    abort(404);
}

$tokenHash = hash("sha256", $rawToken);

$db = App::resolve(Database::class);

$verification = $db->query(
    "SELECT 
        ev.user_id, 
        ev.expires_at, 
        ev.consumed_at, 
        u.email, 
        u.role, 
        u.email_verified 
    FROM email_verifications ev 
    JOIN users u ON u.id = ev.user_id
    WHERE ev.token_hash = :token_hash",
    [
        "token_hash" => $tokenHash,
    ]
)
    ->find();

if (
    !$verification ||
    $verification["consumed_at"] !== null ||
    strtotime($verification["expires_at"]) < time() ||
    (int) $verification["email_verified"] === 1
) {
    abort(404);
}

$db->query(
    "UPDATE users SET email_verified = 1 WHERE id = :id",
    [
        "id" => $verification["user_id"],
    ]
);

$db->query(
    "UPDATE email_verifications SET consumed_at = NOW() WHERE user_id = :user_id",
    [
        "user_id" => $verification["user_id"],
    ]
);

$authenticator = new Authenticator();

$authenticator->login([
    "id" => $verification["user_id"],
    "email" => $verification["email"],
    "role" => $verification["role"],
]);

$_SESSION["user"]["2fa_verified"] = true;

redirect("/");



