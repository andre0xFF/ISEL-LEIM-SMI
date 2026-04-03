<?php

use Core\App;
use Core\Database;

// TODO: Add validation logic.

$db = App::resolve(Database::class);

$db->query("INSERT INTO users(email, password) VALUES(:email, :password)", [
    "email" => $_POST["email"],
    "password" => password_hash($_POST["password"], PASSWORD_BCRYPT),
]);

redirect("/users");
