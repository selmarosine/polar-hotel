<?php

use Dotenv\Parser\Value;

require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";

require __DIR__ . "/app/getRooms.php";
require __DIR__ . "/app/getReviews.php"; // get count of reviews

if (isset($_GET["check-in"], $_GET["check-out"])) {
    // Check if user has selected check out earlier then check in
    $searchCheckIn = $_GET["check-in"] < $_GET["check-out"] ? $_GET["check-in"] : $_GET["check-out"];
    $searchCheckOut = $_GET["check-out"] > $_GET["check-in"] ? $_GET["check-out"] : $_GET["check-in"];

    // Get booked rooms ids
    require __DIR__ . "/app/getBookedRooms.php";

    $rooms = array_filter($rooms, function (array $room) use ($bookedRoomsIds) {
        if (!in_array($room["id"], $bookedRoomsIds)) {
            return $room;
        }
    });
}

?>
<main>
    <section class="hero">
        <div class="hero-text-container">
            <h3>Svalbard</h3>
            <p>Discover Polar Hotel in Svalbard where nature, cuisine, and wildlife converge. Immerse yourself in arctic beauty, relish in exquisite dining inspired by the land, and witness the untamed wildlife. Your adventure begins here!</p>
        </div>
    </section>
    <section class="rooms-section">
        <form class="rooms-filter-container">
            <div class="check-in-out-search">
                <input value="<?= isset($searchCheckIn) ? $searchCheckIn : ""; ?>" required class="check-date-input" type="date" name="check-in" id="check-in" min="2024-01-01" max="2024-01-31">
                <input value="<?= isset($searchCheckOut) ? $searchCheckOut : ""; ?>" required class="check-date-input" type="date" name="check-out" id="check-out" min="2024-01-01" max="2024-01-31">
                <button class="submit-btn-blue" type="submit">Search</button>
                <?php if (isset($searchCheckIn, $searchCheckOut)) : ?>
                    <a class="error-msg-card center" href="index.php">Clear</a>
                <?php endif; ?>
            </div>
        </form>
        <h3 class="rooms-container-title">Rooms</h3>
        <div class="rooms-container">
            <?php foreach ($rooms as $room) : ?>
                <a href=<?= "room.php?room=" . $room["id"]; ?>>
                    <div class="room-card text-dark-blue">
                        <img class="room-card-image text-dark-blue" src=<?= "./assets/images/" . $room["images"][0]; ?> alt="room">
                        <div class="room-card-text-content">
                            <div class="space-between">
                                <h3><?= $room["name"]; ?></h3>
                                <h3><?= "$" . $room["price"]; ?></h3>
                            </div>
                            <span><?= $room["description"]; ?></span>
                            <?php if (key_exists($room["id"], $reviewsCount)) : ?>
                                <div><?= $reviewsCount[$room["id"]] . " reviews" ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <?php if (count($rooms) === 0) : ?>
            <h3 class="no-rooms-container">No rooms available</h3>
        <?php endif; ?>
    </section>
    <section class="explore-activities-section">
        <div>
            <h3>Explore Svalbard</h3>
            <p>Polar hotel offers many activities to do during your stay in Svalbard,</p>
            <a href="activities.php" class="btn-white">Explore</a>
        </div>
    </section>
</main>

<?php require_once __DIR__ . "/views/footer.php"; ?>
