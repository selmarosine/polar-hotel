<?php
require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";

require __DIR__ . "/app/getRooms.php";

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
            <?php require __DIR__ . "/views/dateSearch.php"; ?>
            <div class="sort-btn-stroke">
                <i class="fa-solid fa-arrows-up-down"></i>
                <span>Sort by: Rating (high to low)</span>
            </div>
        </form>
        <h3 class="rooms-container-title">Rooms</h3>
        <div class="rooms-container">
            <?php foreach ($rooms as $room) : ?>
                <a href=<?= "/room.php?room=" . $room["id"]; ?>>
                    <div class="room-card text-dark-blue">
                        <img class="room-card-image text-dark-blue" src=<?= "./assets/images/" . $room["images"][0]; ?> alt="cabin_snow_yellow">
                        <div class="room-card-text-content">
                            <div class="space-between">
                                <h3><?= $room["name"]; ?></h3>
                                <h3><?= "$" . $room["price"]; ?></h3>
                            </div>
                            <span><?= $room["description"]; ?></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="explore-activities-section">
        <div>
            <h3>Explore Svalbard</h3>
            <p>Polar hotel offers many activities to do during your stay in Svalbard,</p>
            <a href="/activities.php" class="btn-white">Explore</a>
        </div>
    </section>
</main>

<?php require_once __DIR__ . "/views/footer.php"; ?>