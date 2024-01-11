<?php

require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";

require __DIR__ . "/app/getRooms.php";
require __DIR__ . "/app/getReviews.php"; // get count of reviews

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$stars = intval($_ENV["STARS"]);

// Available dates form rooms search
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

$errorMessages = isset($_SESSION["bookingErrors"]) ? $_SESSION["bookingErrors"] : [];
unset($_SESSION["bookingErrors"]);

?>
<main>
    <section class="hero">
        <div class="hero-text-container">
            <h3><?= $_ENV["ISLAND_NAME"] ?></h3>
            <p>The Polar Hotel in Svalbard offers a cozy stay amidst Arctic beauty. Nestled in Longyearbyen, it provides a unique experience with stunning views, making it an ideal retreat for those seeking an adventurous getaway in the Arctic.</p>
            <div>
                <?php for ($i = 0; $i < $stars; $i++) : ?>
                    <i class="fa-solid fa-star"></i>
                <?php endfor; ?>
            </div>
        </div>
    </section>
    <section class="rooms-section">
        <div class="rooms-filter-search-title">Already have a date in mined ?</div>
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
        <div class="<?= count($errorMessages) > 0 ? "error-dates-search" : ""; ?>">
            <?php require __DIR__ . "/views/errorMessages.php"; ?>
        </div>
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
                            <span><?= nl2br($room["description"]); ?></span>
                            <?php if (key_exists($room["id"], $reviewsCount)) : ?>
                                <div class="review-count"><?= $reviewsCount[$room["id"]] . (intval($reviewsCount[$room["id"]]) > 1 ? " reviews" : " review") ?></div>
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
