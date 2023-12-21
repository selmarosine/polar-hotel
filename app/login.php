<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";
require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

if (isset($_POST["password"])) {
    $password = $_POST["password"];
    unset($_POST["password"]);

    if (!isValidUuid($password) || $password !== $_ENV["API_KEY"]) {
        $_SESSION["loginError"][] = "Password incorrect, is this really an admin ?";
        redirect("./../login.php");
    }

    $_SESSION["admin"] = time() + 3600;
    redirect("./../admin.php");
}

redirect("./../login.php");
