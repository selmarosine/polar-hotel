<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

// Get booked dates for one room
if (isset($room["id"])) {
    $getBookedRooms = $db->prepare("SELECT * FROM booked_rooms WHERE room_id = :room_id");
    $getBookedRooms->bindParam(":room_id", $room["id"], PDO::PARAM_STR);
    $getBookedRooms->execute();

    $bookedRooms = $getBookedRooms->fetchAll(PDO::FETCH_ASSOC);
}

// Get booked dates for all rooms by selected check in/out
if (isset($searchCheckIn, $searchCheckOut)) {
    $getBookedRoomsIds = $db->prepare("SELECT booked_rooms.room_id AS id FROM rooms INNER JOIN booked_rooms ON booked_rooms.room_id = rooms.id WHERE booked_rooms.check_in >= :check_in AND booked_rooms.check_out <= :check_out");
    $getBookedRoomsIds->bindParam(":check_in", $searchCheckIn, PDO::PARAM_STR);
    $getBookedRoomsIds->bindParam(":check_out", $searchCheckOut, PDO::PARAM_STR);
    $getBookedRoomsIds->execute();

    $bookedRoomsIds = array_column($getBookedRoomsIds->fetchAll(PDO::FETCH_ASSOC), "id");
}
