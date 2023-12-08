<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

$getRooms = $db->query("SELECT rooms.id, rooms.name, rooms.price, rooms.description, image_room.image FROM rooms
INNER JOIN image_room ON image_room.room_id = rooms.id");

$getRooms->execute();

$rooms = $getRooms->fetchAll(PDO::FETCH_ASSOC);

$mappedRooms = [];

foreach ($rooms as $room) {
    $id = $room["id"];

    if (!isset($mappedRooms[$id])) {
        $mappedRooms[$id] = [
            "id" => $id,
            "name" => $room["name"],
            "price" => $room["price"],
            "description" => $room["description"],
            "images" => [],
        ];
    }

    $mappedRooms[$id]["images"][] = $room["image"];
}

$rooms = array_values($mappedRooms);
