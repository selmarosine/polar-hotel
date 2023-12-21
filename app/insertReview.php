<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

$roomId = htmlspecialchars($_GET["room"]) ?? "";

if (isset($_GET["name"], $_GET["review"])) {
    $name = htmlspecialchars(trim(ucwords($_GET["name"])));
    $review = htmlspecialchars(trim(ucfirst($_GET["review"])));

    $insertReview = $db->prepare("INSERT INTO room_reviews (room_id, name, review) VALUES (:room_id, :name, :review)");
    $insertReview->bindParam(":room_id", $roomId, PDO::PARAM_STR);
    $insertReview->bindParam(":name", $name, PDO::PARAM_STR);
    $insertReview->bindParam(":review", $review, PDO::PARAM_STR);
    $insertReview->execute();

    $_SESSION["reviewSuccess"] = "$name, thanks for leaving a review";
}

redirect("./../room.php?room=$roomId");
