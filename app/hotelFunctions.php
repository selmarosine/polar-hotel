<?php

/*
Here's something to start your career as a hotel manager.

One function to connect to the database you want (it will return a PDO object which you then can use.)
    For instance: $db = connect('hotel.db');
                  $db->prepare("SELECT * FROM bookings");

one function to create a guid,
and one function to control if a guid is valid.
*/

function connect(string $dbName): object
{
    $dbPath = __DIR__ . '/' . $dbName;
    $db = "sqlite:$dbPath";

    // Open the database file and catch the exception if it fails.
    try {
        $db = new PDO($db);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Failed to connect to the database";
        throw $e;
    }
    return $db;
}

function guidv4(string $data = null): string
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function isValidUuid(string $uuid): bool
{
    if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
        return false;
    }
    return true;
}

function redirect(string $path)
{
    header("Location: $path");
    exit;
}

function monthArrayDate(int $timeStamp): array
{
    return [
        "date" => date("Y-m-d", $timeStamp),
        "dayOfWeek" => intval(date("N", $timeStamp)),
        "dayDate" => intval(date("d", $timeStamp)),
        "month" => intval(date("m", $timeStamp)),
    ];
}

function getMonth(int $monthIndex, int $year): array
{
    // Creates an array of 42 dates to fill 6 weeks in a calendar

    $monthLength = cal_days_in_month(CAL_GREGORIAN, $monthIndex, $year); // Length of the selected month
    $month = [];

    $firstDay = date("N", mktime(0, 0, 0, $monthIndex, 1, $year));

    // Days before and after the selected month
    $daysBefore = $firstDay - 1;
    $daysAfter = 42 - $monthLength - $daysBefore;

    // Days before current selected month
    for ($idx = $daysBefore; $idx > 0; $idx--) {
        $timeStamp = mktime(0, 0, 0, $monthIndex, 1 - $idx, $year);
        $month[] = monthArrayDate($timeStamp);
    }

    // Selected month
    for ($idx = 0; $idx < $monthLength; $idx++) {
        $timeStamp = mktime(0, 0, 0, $monthIndex, $idx + 1, $year);
        $month[] = monthArrayDate($timeStamp);
    }

    // Days after selected month
    for ($idx = 1; $idx <= $daysAfter; $idx++) {
        $timeStamp = mktime(0, 0, 0, $monthIndex, $monthLength + $idx, $year);
        $month[] = monthArrayDate($timeStamp);
    }

    return $month;
}

function filterForId(array $arrays, string $arrayId): array
{
    $filteredArray = array_filter($arrays, function ($array) use ($arrayId) {
        return $array["id"] === $arrayId;
    });

    return reset($filteredArray);
}
