<?php

declare(strict_types=1);

session_start();

// Set the default timezone to Coordinated Universal Time.
date_default_timezone_set('UTC');

mb_internal_encoding('UTF-8');

// Include the helper functions.
require __DIR__ . '/hotelFunctions.php';

$db = new PDO("sqlite:" . __DIR__ . "/database/polar-hotel.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->exec("PRAGMA foreign_keys = ON;"); // For on delete cascade to fork
