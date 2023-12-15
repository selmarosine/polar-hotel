<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

$selectBookedRooms = $db->prepare("SELECT * FROM booked_rooms WHERE room_id = :room_id");
$selectBookedRooms->bindParam(":room_id", $room["id"], PDO::PARAM_STR);
$selectBookedRooms->execute();

$bookedRooms = $selectBookedRooms->fetchAll(PDO::FETCH_ASSOC);
