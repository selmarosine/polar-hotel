<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";
require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$stars = intval($_ENV["STARS"]);

$selectActivities = $db->query("SELECT * FROM activities");
$selectActivities->execute();

$activities = $selectActivities->fetchAll(PDO::FETCH_ASSOC);
