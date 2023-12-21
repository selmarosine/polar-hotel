<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_GET["name"], $_GET["discount"], $_GET["requirement"], $_GET["amount"], $_GET["rooms"], $_GET["id"])) {
    $name = htmlspecialchars(trim(ucfirst($_GET["name"])));
    $discount = intval($_GET["discount"]);
    $requirement = htmlspecialchars($_GET["requirement"]);
    $reqAmount = intval($_GET["amount"]);
    $rooms = $_GET["rooms"];
    $offerId = $_GET["id"];

    // update offer
    $insertOffer = $db->prepare("UPDATE offers SET name = :name, discount = :discount, requirement = :requirement, requirement_amount = :requirement_amount");
    $insertOffer->bindParam(":name", $name, PDO::PARAM_STR);
    $insertOffer->bindParam(":discount", $discount, PDO::PARAM_INT);
    $insertOffer->bindParam(":requirement", $requirement, PDO::PARAM_STR);
    $insertOffer->bindParam(":requirement_amount", $reqAmount, PDO::PARAM_INT);
    $insertOffer->execute();

    // Get rooms for offer
    $currentRooms = $db->prepare("SELECT room_id FROM offer_room WHERE offer_id = :offer_id");
    $currentRooms->bindParam(":offer_id", $offerId, PDO::PARAM_STR);
    $currentRooms->execute();
    $currentRooms = array_values($currentRooms->fetchAll());


    // For when the admin selects a new room in update form
    $roomsToInsert = array_filter($rooms, function ($room) use ($currentRooms) {
        return !in_array($room, array_column($currentRooms, "room_id"));
    });
    // Reset index
    $roomsToInsert = array_values($roomsToInsert);

    // For when the admin deselects a room in update form
    $roomsToDelete = array_filter($currentRooms, function ($currentRoom) use ($rooms) {
        return !in_array($currentRoom["room_id"], $rooms);
    });
    // Reset index
    $roomsToDelete = array_values($roomsToDelete);

    if (!empty($roomsToInsert)) {
        // Insert the selected rooms that dose not already have the offer
        $offerRooms = array_map(fn ($room) => [$offerId, $room], $roomsToInsert);
        $placeHolder = rtrim(str_repeat("(?, ?), ", count($offerRooms)), ", ");
        $insertOfferRooms = $db->prepare("INSERT INTO offer_room (offer_id, room_id) VALUES $placeHolder");
        $insertOfferRooms->execute(array_merge(...$offerRooms));
    }

    if (!empty($roomsToDelete)) {
        // Delete the deselected rooms
        $placeholdersDelete = rtrim(str_repeat("?, ", count($roomsToDelete)), ", ");
        $deleteOfferRooms = $db->prepare("DELETE FROM offer_room WHERE offer_id = ? AND room_id IN ($placeholdersDelete)");
        $deleteOfferRooms->execute([$offerId, ...array_column($roomsToDelete, "room_id")]);
    }

    $_SESSION["adminFormSuccess"] = "Discount updated successfully";
    redirect("./../admin.php?form=offerForm");
}

$_SESSION["adminFormErrors"][] = "Not all fields are filled in, please try again.";
redirect("./../admin.php?form=offerForm");
