<?php

require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";

require __DIR__ . "/app/getRooms.php";
require __DIR__ . "/app/getActivities.php";
require __DIR__ . "/app/getOffers.php";

// Filter for room
$roomId = $_GET["room"];

$room = filterForId($rooms, $roomId);

// getBookedRooms.php depends on having $room["id"], there fore requiring it after $room is set
require __DIR__ . "/app/getBookedRooms.php";

$bookedCheckIn = array_column($bookedRooms, "check_in");
$bookedCheckOut = array_column($bookedRooms, "check_out");

// Filter for discount for room
$roomOffers = array_filter($offers, function ($offer) use ($room) {
    return in_array($room["id"], $offer["rooms"]);
});

$errorMessages = isset($_SESSION["bookingErrors"]) ? $_SESSION["bookingErrors"] : [];
unset($_SESSION["bookingErrors"]);
?>

<main class="room-main max-w-section">
    <div class="room-content-order">
        <div class="column room-info-container space-between">
            <div>
                <div class="space-between name-price-title">
                    <h1><?= $room["name"]; ?></h1>
                    <h3><?= "$" . $room["price"]; ?></h3>
                </div>
                <div><?= $room["description"]; ?></div>
            </div>
            <?php if (count($roomOffers) > 0) : ?>
                <div class="room-discount-container">
                    <h3 class="room-discount-title">Discounts for <?= $room["name"]; ?></h3>
                    <?php foreach ($roomOffers as $roomOffer) : ?>
                        <div class="room-discount-card"><?= $roomOffer["name"]; ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
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
                $calendarIdentifier = "check_in";
                require __DIR__ . "/views/calendar.php"; ?>
            </div>
            <div>
                <h3>Check out</h3>
                <?php
                $calendarIdentifier = "check_out";
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
            <input autocomplete="on" placeholder="Code ..." class="transfer-code-input" type="text" name="transfer-code" id="transfer-code" required>
        </div>
        <div class="space-between">
            <h3>Total price: <span id="total-price"><?= "$" . $room["price"] ?></span></h3>
            <div id="discount-sum" class="discount-text"></div>
        </div>
        <?php require __DIR__ . "/views/errorMessages.php"; ?>
        <input type="hidden" name="room" value="<?= $roomId ?>">
        <input type="hidden" name="total-cost" id="total-cost" value="<?= $room["price"] ?>">
        <button type="submit" class="submit-btn-blue cart-btn">Book <?= $room["name"]; ?></i></button>
    </form>
</main>
<script>
    const offers = <?= json_encode($roomOffers); ?>; // To handle active discount when user is booking room.
</script>
<script src="assets/javascript/room.js"></script>

<?php require_once __DIR__ . "/views/footer.php"; ?>
