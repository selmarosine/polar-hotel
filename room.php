<?php

require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";

require __DIR__ . "/app/getRooms.php";
require __DIR__ . "/app/getActivities.php";

$roomId = intval($_GET["room"]);

// Get the selected room from $rooms
$filteredRooms = array_filter($rooms, function ($room) use ($roomId) {
    return $room["id"] === $roomId;
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
        <div class="check-in-out-calenders">
            <div>
                <h3>Check in</h3>
                <?php
                $calendarIdentifier = "_checkin";
                require __DIR__ . "/views/calendar.php"; ?>
            </div>
            <div>
                <h3>Check out</h3>
                <?php
                $calendarIdentifier = "_checkout";
                require __DIR__ . "/views/calendar.php"; ?>
            </div>
        </div>
        <div class="room-activities">
            <?php foreach ($activities as $activity) : ?>
                <div class="room-activities-card">
                    <img src="<?= "assets/images/" . $activity["image"] ?>" alt="activity">
                    <input type="checkbox" name="activity" value="<?= $activity["id"] ?>">
                    <div><?= "$" . $activity["price"] . " - " . $activity["activity"] ?></div>
                    <a href="activities.php" class="text-dark-blue flex-grow">
                        <i class="fa-solid fa-link"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div>
            <label for="transfer-code">
                <h3>Enter your transfer code</h3>
            </label>
            <input class="transfer-code-input" type="text" name="transfer-code" id="transfer-code" required>
        </div>
        <input type="hidden" name="room" value="<?= $roomId ?>">
        <button type="submit" class="submit-btn-blue">Book <?= $room["name"] ?></button>
    </form>
</main>

<?php require_once __DIR__ . "/views/footer.php"; ?>