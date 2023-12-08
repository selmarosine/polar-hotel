<?php

require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";

require __DIR__ . "/app/getRooms.php";

// Get the selected room from $rooms
$filteredRooms = array_filter($rooms, function ($room) {
    return $room["id"] === intval($_GET["room"]);
});

$room = reset($filteredRooms);
?>

<main class="room-main max-w-section">
    <div class="room-content-order">
        <div class="column room-info-container">
            <div class="space-between name-price-title">
                <h1><?= $room["name"]; ?></h1>
                <h3><?= "$" . $room["price"]; ?></h3>
            </div>
            <div><?= $room["description"]; ?></div>
        </div>
        <div class="room-gallery-grid">
            <?php foreach ($room["images"] as $image) : ?>
                <img src=<?= "./assets/images/" . $image; ?> alt="hotel room">
            <?php endforeach; ?>
        </div>
    </div>
    <form class="book-room-form">
        <?php require __DIR__ . "/views/dateSearch.php"; ?>
    </form>
</main>

<?php require_once __DIR__ . "/views/footer.php"; ?>