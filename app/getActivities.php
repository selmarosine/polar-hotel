<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

$selectActivities = $db->query("SELECT * FROM activities");
$selectActivities->execute();

$activities = $selectActivities->fetchAll(PDO::FETCH_ASSOC);
