<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

require_once __DIR__ . "/autoload.php";
require __DIR__ . '/../vendor/autoload.php';

$client = new Client([
    "base_uri" => "https://www.yrgopelag.se/centralbank/"
]);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

if (isset($_POST["date-checkin"], $_POST["date-checkout"], $_POST["transfer-code"], $_POST["room"], $_POST["total-cost"])) {
    $transferCode = $_POST["transfer-code"];
    $roomId = $_POST["room"];
    $checkIn = $_POST["date-checkin"];
    $checkOut = $_POST["date-checkout"];
    $activitiesId = $_POST["activities"] ?? "";
    $totalCost = intval($_POST["total-cost"]);

    // Check if the format of the code is valid
    if (!isValidUuid($transferCode)) {
        $_SESSION["bookingErrors"][] = "Not a transfer code";
        redirect("/room.php?room=" . $roomId);
    }

    $insertBooking = $db->prepare("INSERT INTO booked_rooms (check_in, check_out, total_cost, room_id) VALUES (:check_in, :check_out, :total_cost, :room_id)");
    $insertBooking->bindParam(":check_in", $checkIn, PDO::PARAM_STR);
    $insertBooking->bindParam(":check_out", $checkOut, PDO::PARAM_STR);
    $insertBooking->bindParam(":total_cost", $totalCost, PDO::PARAM_INT);
    $insertBooking->bindParam(":room_id", $roomId, PDO::PARAM_STR);
    $insertBooking->execute();

    // // Check if code is valid in bank
    // try {
    //     $request = $client->post("transferCode", [
    //         'form_params' => [
    //             'transferCode' => $transferCode,
    //             'totalcost' => $totalCost
    //         ],
    //     ]);

    //     $response = json_decode($request->getBody()->getContents(), true);
    //     $_SESSION["bookingSuccess"] = "You have successful booked your stay at Polar Hotel from $checkIn to $checkOut.";
    // } catch (ClientException $e) {
    //     $_SESSION["bookingErrors"][] = "This is not a valid transfer code,  please check with you bank for a new code.";
    //     redirect("/room.php?room=" . $roomId);
    // }

    // // Deposit money
    // try {
    //     $deposit = $client->post("deposit", [
    //         "form_params" => [
    //             "user" => $_ENV["USER_NAME"],
    //             "transferCode" => $response["transferCode"]
    //         ]
    //     ]);
    // } catch (ClientException $e) {
    //     $_SESSION["bookingErrors"][] = "Error while booking your room, please try again.";
    //     redirect("/room.php?room=" . $roomId);
    // }
}

redirect("/room.php?room=" . $roomId);
