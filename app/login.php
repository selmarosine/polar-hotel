<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";
require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

if (isset($_POST["password"])) {
    $password = $_POST["password"];
    unset($_POST["password"]);

    if (!isValidUuid($password)) {
        $_SESSION["loginError"] = true;
        redirect("/login.php");
    }

    if ($password === $_ENV["API_KEY"]) {
        $_SESSION["admin"] = true;
        redirect("/admin.php");
    }
}

$_SESSION["loginError"] = true;
redirect("/login.php");
