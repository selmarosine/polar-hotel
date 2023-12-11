<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";
require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$stars = intval($_ENV["STARS"]) * 10;

$getRooms = $db->query("SELECT rooms.id, rooms.name, rooms.price, rooms.description, image_room.image FROM rooms
INNER JOIN image_room ON image_room.room_id = rooms.id");

$getRooms->execute();

$rooms = $getRooms->fetchAll(PDO::FETCH_ASSOC);

$mappedRooms = [];

foreach ($rooms as $room) {
    $id = $room["id"];
    $price = intval($room["price"]);
    $price = $price + round($price * ($stars / 100));

    if (!isset($mappedRooms[$id])) {
        $mappedRooms[$id] = [
            "id" => $id,
            "name" => $room["name"],
            "price" => $price,
            "description" => $room["description"],
            "images" => [],
        ];
    }

    $mappedRooms[$id]["images"][] = $room["image"];
}

$rooms = array_values($mappedRooms);

unset($room);
