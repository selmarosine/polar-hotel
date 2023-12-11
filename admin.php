<?php
require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";
require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$stars = intval($_ENV["STARS"]);


if (!isset($_SESSION["admin"])) {
    redirect("/login.php");
}

require __DIR__ . "/app/getRooms.php";
require __DIR__ . "/app/getActivities.php";

$form = isset($_GET["form"]) ? $_GET["form"] : "roomForm";

if (isset($_GET["edit"])) {
    if (isset($_GET["room"])) {
        $roomId = intval($_GET["room"]);
        $room = filterForId($rooms, $roomId);
        $room["price"] = $room["price"] - $stars;
    }

    if (isset($_GET["activity"])) {
        $activityId = intval($_GET["activity"]);
        $activity = filterForId($activities, $activityId);
        $activity["price"] = $activity["price"] - $stars;
    }
}

?>

<main class="admin-main">
    <section class="max-w-section admin-section">
        <div class="flex-md admin-form-selector-container">
            <a href="admin.php?form=roomForm" class="submit-btn-blue form-selector">Room</a>
            <a href="admin.php?form=activityForm" class="submit-btn-blue form-selector">Activity</a>
        </div>
        <?php require __DIR__ . "/views/$form.php"; ?>
        <div class="rooms-admin-container">
            <h3>Rooms</h3>
            <div class="rooms-container">
                <?php foreach ($rooms as $room) : ?>
                    <div class="room-card text-dark-blue">
                        <img class="room-card-image" src=<?= "./assets/images/" . $room["images"][0]; ?> alt="cabin_snow_yellow">
                        <div class="room-card-text-content">
                            <a class="text-dark-blue" href="<?= "admin.php?form=roomForm&edit=update&room=" . $room["id"]; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <div class="space-between">
                                <h3><?= $room["name"]; ?></h3>
                                <h3><?= "$" . $room["price"]; ?></h3>
                            </div>
                            <span><?= $room["description"]; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="rooms-admin-container">
            <h3>Activities</h3>
            <div class="rooms-container">
                <?php foreach ($activities as $activity) : ?>
                    <div class="room-card text-dark-blue">
                        <img class="room-card-image" src=<?= "./assets/images/" . $activity["image"]; ?> alt="activity">
                        <div class="room-card-text-content">
                            <a class="text-dark-blue" href="<?= "admin.php?form=activityForm&edit=update&activity=" . $activity["id"]; ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <div class="space-between">
                                <h3><?= $activity["activity"]; ?></h3>
                                <h3><?= "$" . $activity["price"]; ?></h3>
                            </div>
                            <span><?= $activity["description"]; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<?php require_once __DIR__ . "/views/footer.php"; ?>