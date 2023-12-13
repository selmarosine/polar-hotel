<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

$getOffers = $db->query("SELECT offers.*, offer_room.room_id FROM offers INNER JOIN offer_room ON offer_room.offer_id = offers.id;");

$offers = $getOffers->fetchAll(PDO::FETCH_ASSOC);

$mappedOffers = [];

foreach ($offers as $offer) {
    $id = $offer["id"];

    if (!isset($mappedOffers[$id])) {
        $mappedOffers[$id] = [
            "id" => $id,
            "name" => $offer["name"],
            "discount" => intval($offer["discount"]),
            "requirement" => $offer["requirement"],
            "requirement_amount" => $offer["requirement_amount"],
            "rooms" => [],
        ];
    }

    $mappedOffers[$id]["rooms"][] = $offer["room_id"];
}

// Return array with out associative keys
$offers = array_values($mappedOffers);
