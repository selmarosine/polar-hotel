<?php

require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";

require __DIR__ . "/app/getRooms.php";
require __DIR__ . "/app/getActivities.php";

$roomId = $_GET["room"];

$room = filterForId($rooms, $roomId);

$errorMessages = isset($_SESSION["bookingErrors"]) ? $_SESSION["bookingErrors"] : [];
unset($_SESSION["bookingErrors"]);

$successMessage = isset($_SESSION["bookingSuccess"]) ? $_SESSION["bookingSuccess"] : "";
unset($_SESSION["bookingSuccess"]);
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
    <form method="post" class="book-room-form" action="app/bookRoom.php">
        <div class="check-in-out-calenders">
            <div>
                <h3>Check in</h3>
                <?php
                $calendarIdentifier = "-checkin";
                require __DIR__ . "/views/calendar.php"; ?>
            </div>
            <div>
                <h3>Check out</h3>
                <?php
                $calendarIdentifier = "-checkout";
                require __DIR__ . "/views/calendar.php"; ?>
            </div>
        </div>
        <div class="room-activities">
            <?php foreach ($activities as $activity) : ?>
                <div class="room-activities-card">
                    <img src="<?= "assets/images/" . $activity["image"] ?>" alt="activity">
                    <input data-price="<?= $activity["price"]; ?>" class="activity-check" type="checkbox" name="activities[]" value="<?= $activity["id"] ?>">
                    <div><?= "$" . $activity["price"] . " - " . $activity["name"] ?></div>
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
            <input placeholder="Code ..." class="transfer-code-input" type="text" name="transfer-code" id="transfer-code" required>
        </div>
        <h3>Total price: <span id="total-price"><?= "$" . $room["price"] ?></span></h3>
        <?php require __DIR__ . "/views/errorMessages.php"; ?>
        <?php if (strlen($successMessage) > 0) : ?>
            <div class="success-message"><?= $successMessage; ?></div>
        <?php endif; ?>
        <input type="hidden" name="room" value="<?= $roomId ?>">
        <input type="hidden" name="total-cost" id="total-cost" value="<?= $room["price"] ?>">
        <button type="submit" class="submit-btn-blue">Book <?= $room["name"] ?></button>
    </form>
</main>

<?php require_once __DIR__ . "/views/footer.php"; ?>