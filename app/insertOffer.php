<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_GET["name"], $_GET["discount"], $_GET["requirement"], $_GET["amount"], $_GET["rooms"])) {
    $name = htmlspecialchars(trim(ucfirst($_GET["name"])));
    $discount = intval($_GET["discount"]);
    $requirement = htmlspecialchars($_GET["requirement"]);
    $reqAmount = intval($_GET["amount"]);
    $rooms = $_GET["rooms"];
    $offerId = guidv4();

    // insert offer
    $insertOffer = $db->prepare("INSERT INTO offers (id, name, discount, requirement, requirement_amount) VALUES (:id, :name, :discount, :requirement, :requirement_amount)");
    $insertOffer->bindParam(":id", $offerId, PDO::PARAM_STR);
    $insertOffer->bindParam(":name", $name, PDO::PARAM_STR);
    $insertOffer->bindParam(":discount", $discount, PDO::PARAM_INT);
    $insertOffer->bindParam(":requirement", $requirement, PDO::PARAM_STR);
    $insertOffer->bindParam(":requirement_amount", $reqAmount, PDO::PARAM_INT);
    $insertOffer->execute();

    // insert all the selected rooms the admin wants the offer to be valid for.
    $offerRooms = array_map(fn ($room) => [$offerId, $room], $rooms);
    $placeHolder = rtrim(str_repeat("(?, ?), ", count($rooms)), ", ");
    $insertOfferRooms = $db->prepare("INSERT INTO offer_room (offer_id, room_id) VALUES $placeHolder");
    $insertOfferRooms->execute(array_merge(...$offerRooms));

    $_SESSION["adminFormSuccess"] = "Discount created successfully";
    redirect("./../admin.php?form=offerForm");
}

$_SESSION["adminFormErrors"][] = "Not all fields are filled in, please try again.";
redirect("./../admin.php?form=offerForm");
