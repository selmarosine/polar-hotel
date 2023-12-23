<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

try {
    $selectActivities = $db->query("SELECT * FROM activities");
    $selectActivities->execute();

    $activities = $selectActivities->fetchAll();
} catch (PDOException $e) {
    $activities = [];
}
