<?php

function connect(string $dbName): object
{
    $dbPath = __DIR__ . "/database/$dbName";
    $db = "sqlite:$dbPath";

    // Open the database file and catch the exception if it fails.
    try {
        $db = new PDO($db);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->exec("PRAGMA foreign_keys = ON;"); // For on delete cascade to fork
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

    $firstDay = date("N", mktime(0, 0, 0, $monthIndex, 1, $year)); // returns a number 1 - 7 representing Monday - Sunday depending on the date

    // Days before and after the selected month
    $daysBefore = $firstDay - 1; // To fill the first week of the selected month
    $daysAfter = 42 - $monthLength - $daysBefore; // Fill out the rest of the 6 weeks

    // Days before current selected month
    if ($daysBefore > 0) {
        for ($idx = $daysBefore; $idx > 0; $idx--) {
            $timeStamp = mktime(0, 0, 0, $monthIndex, 1 - $idx, $year);
            $month[] = monthArrayDate($timeStamp);
        }
    }

    // Selected month
    for ($idx = 0; $idx < $monthLength; $idx++) {
        $timeStamp = mktime(0, 0, 0, $monthIndex, $idx + 1, $year);
        $month[] = monthArrayDate($timeStamp);
    }

    // Days after selected month
    if ($daysAfter > 0) {
        for ($idx = 1; $idx <= $daysAfter; $idx++) {
            $timeStamp = mktime(0, 0, 0, $monthIndex, $monthLength + $idx, $year);
            $month[] = monthArrayDate($timeStamp);
        }
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

function isDateBooked(int $date, array $bookedCheckIn, array $bookedCheckOut): bool
{
    foreach ($bookedCheckIn as $index => $checkIn) {
        $checkOut = $bookedCheckOut[$index];
        if ($date >= strtotime($checkIn) && $date <= strtotime($checkOut)) {
            return true;
        }
    }
    return false;
}

function calcDateDiff(string $dateA, string $dateB): int
{
    $dateA = new DateTime($dateA);
    $dateB = new DateTime($dateB);

    $diff = $dateA->diff($dateB);

    return $diff->days + 1;
}

function calcActivitiesSum(array $activities, array $activitiesIds): int
{
    $price = 0;

    foreach ($activities as $activity) {
        if (in_array($activity["id"], $activitiesIds)) {
            $price += intval($activity["price"]);
        }
    }

    return $price;
}

function calcTotalPrice(array $offers, int $days, int $price): int
{
    $discount = array_reduce($offers, function (int $carry, array $offer) use ($days, $price) {
        if ($offer["requirement"] === "days") {
            if ($days > $offer["requirement_amount"]) {
                return $carry + $offer["discount"];
            }
        }

        if ($offer["requirement"] === "price") {
            if ($price > $offer["requirement_amount"]) {
                return $carry + $offer["discount"];
            }
        }

        return $carry;
    }, 0);

    $discount = floor(($discount / 100) * $price);

    return $price - $discount;
}
