<?php

declare(strict_types=1);

session_start();

// Set the default timezone to Coordinated Universal Time.
date_default_timezone_set('UTC');

mb_internal_encoding('UTF-8');

// Include the helper functions.
require __DIR__ . '/hotelFunctions.php';
