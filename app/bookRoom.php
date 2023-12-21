<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

require_once __DIR__ . "/autoload.php";
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . "/getRooms.php";
require __DIR__ . "/getActivities.php";
require __DIR__ . "/getOffers.php";

$client = new Client([
    "base_uri" => "https://www.yrgopelag.se/centralbank/"
]);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

if (isset($_POST["check_in"], $_POST["check_out"], $_POST["transfer-code"], $_POST["room"], $_POST["total-cost"])) {
    $transferCode = $_POST["transfer-code"];
    $roomId = $_POST["room"];
    $checkIn = $_POST["check_in"];
    $checkOut = $_POST["check_out"];
    $activitiesIds = $_POST["activities"] ?? "";
    $totalCost = intval($_POST["total-cost"]);

    // Check if $totalCost is the correct price
    $room = filterForId($rooms, $roomId);
    $roomPrice = $room["price"] * calcDateDiff($checkIn, $checkOut); // price for room * days booked
    $activitiesTotal = calcActivitiesSum($activities, $activitiesIds);
    $roomOffers = array_filter($offers, function ($offer) use ($roomId) {
        return in_array($roomId, $offer["rooms"]);
    });

    if ($totalCost !== calcTotalPrice($roomOffers, calcDateDiff($checkIn, $checkOut), $roomPrice + $activitiesTotal)) {
        $_SESSION["bookingErrors"][] = "Price has bin altered!";
        redirect("./../room.php?room=$roomId");
    }

    // Check if the format of the code is valid
    if (!isValidUuid($transferCode)) {
        $_SESSION["bookingErrors"][] = "$transferCode is not a transfer code";
        redirect("./../room.php?room=$roomId");
    }

    // // Check if code is valid in bank
    try {
        $request = $client->post("transferCode", [
            'form_params' => [
                'transferCode' => $transferCode,
                'totalcost' => $totalCost
            ],
        ]);

        // Get transfer code for deposit
        $response = json_decode($request->getBody()->getContents(), true);

        if (isset($response["error"])) {
            $_SESSION["bookingErrors"][] = "The code you provided holds no value, check with your bank before booking a room again";
            redirect("./../room.php?room=$roomId");
        }
    } catch (ClientException $e) {
        $_SESSION["bookingErrors"][] = "Error while talking to your bank, please try again later";
        redirect("./../room.php?room=$roomId");
    }

    // Deposit money
    try {
        $deposit = $client->post("deposit", [
            "form_params" => [
                "user" => $_ENV["USER_NAME"],
                "transferCode" => $response["transferCode"]
            ]
        ]);

        $insertBooking = $db->prepare("INSERT INTO booked_rooms (check_in, check_out, total_cost, room_id) VALUES (:check_in, :check_out, :total_cost, :room_id)");
        $insertBooking->bindParam(":check_in", $checkIn, PDO::PARAM_STR);
        $insertBooking->bindParam(":check_out", $checkOut, PDO::PARAM_STR);
        $insertBooking->bindParam(":total_cost", $totalCost, PDO::PARAM_INT);
        $insertBooking->bindParam(":room_id", $roomId, PDO::PARAM_STR);
        $insertBooking->execute();

        $activitiesReceipt = array_map(function ($activity) use ($activitiesIds) {
            if (in_array($activity["id"], $activitiesIds)) {
                return [
                    "name" => $activity["name"],
                    "cost" => $activity["price"]
                ];
            }
        }, $activities);
        // Get rid of null values
        $activitiesReceipt = array_values(array_filter($activitiesReceipt, function ($activity) {
            return $activity !== null;
        }));

        $_SESSION["bookingSuccess"] = "You have successful booked your stay at Polar Hotel from $checkIn to $checkOut.";
        $_SESSION["bookingReceipt"] = [
            "island" => $_ENV["ISLAND_NAME"],
            "hotel" => $_ENV["HOTEL_NAME"],
            "arrival_date" => $checkIn,
            "departure_date" => $checkOut,
            "total_cost" => $totalCost,
            "stars" => intval($_ENV["STARS"]),
            "features" => $activitiesReceipt
        ];
        redirect("./../receipt.php?room=$roomId");
    } catch (ClientException $e) {
        $_SESSION["bookingErrors"][] = "Error while booking your room, please try again later";
        redirect("./../room.php?room=$roomId");
    }
}

redirect("./../room.php?room=$roomId");
