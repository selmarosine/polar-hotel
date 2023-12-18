<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($roomId)) {
    $getReviews = $db->prepare("SELECT name, review, created_date FROM room_reviews WHERE room_id = :room_id");
    $getReviews->bindParam(":room_id", $roomId, PDO::PARAM_STR); // $roomId should be set before requiring this file.
    $getReviews->execute();

    $reviews = $getReviews->fetchAll(PDO::FETCH_ASSOC);
}

$getReviewsCount = $db->query("SELECT COUNT(id) as reviews_count, room_id FROM room_reviews GROUP BY room_id;");
$getReviewsCount->execute();

$reviewsCount = $getReviewsCount->fetchAll(PDO::FETCH_ASSOC);
$reviewsCount = array_combine(
    array_column($reviewsCount, 'room_id'),
    array_column($reviewsCount, 'reviews_count')
);
