<?php
require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";
require_once __DIR__ . "/vendor/autoload.php";

if (!isset($_SESSION["admin"])) {
    redirect("/login.php");
}

if ($_SESSION["admin"] < time()) {
    unset($_SESSION["admin"]);
    redirect("/login.php");
}

$_SESSION["admin"] = time() + 3600; // Update logged in session time

// Get data from db
require __DIR__ . "/app/getRooms.php";
require __DIR__ . "/app/getActivities.php";
require __DIR__ . "/app/getOffers.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$stars = intval($_ENV["STARS"]);

use GuzzleHttp\Client;

$client = new Client([
    "base_uri" => "https://www.yrgopelag.se/centralbank/"
]);

$form = isset($_GET["form"]) ? $_GET["form"] : "roomForm";

// For admin to edit selected product
if (isset($_GET["edit"])) {
    if (isset($_GET["room"])) {
        $roomId = $_GET["room"];
        $room = filterForId($rooms, $roomId);
        $room["price"] = $room["price"] - $stars; // show base price
    }

    if (isset($_GET["activity"])) {
        $activityId = $_GET["activity"];
        $activity = filterForId($activities, $activityId);
    }
    if (isset($_GET["offer"])) {
        $offerId = $_GET["offer"];
        $offer = filterForId($offers, $offerId);
    }
}

$request = $client->post("accountInfo.php", [
    "form_params" => [
        "user" => $_ENV["USER_NAME"],
        "api_key" => $_ENV["API_KEY"],
        "checkAccount" => ""
    ]
]);

$bankAccount = json_decode($request->getBody()->getContents(), true)["credit"];

?>

<main class="admin-main">
    <section class="max-w-section admin-section">
        <div class="hotel-data-container">
            <div class="hotel-data-cell space-between">
                <span>Bank account</span>
                <span><?= "$" . $bankAccount; ?></span>
            </div>
            <div class="hotel-data-cell space-between">
                <span>Stars</span>
                <span>
                    <?php for ($i = 0; $i < $stars; $i++) : ?>
                        <i class="fa-solid fa-star"></i>
                    <?php endfor; ?>
                </span>
            </div>
        </div>
        <div class="flex-md admin-form-selector-container">
            <a href="admin.php?form=roomForm" class="submit-btn-blue form-selector <?= $form === "roomForm" ? "form-active" : "" ?>">Room</a>
            <a href="admin.php?form=activityForm" class="submit-btn-blue form-selector <?= $form === "activityForm" ? "form-active" : "" ?>">Activity</a>
            <a href="admin.php?form=offerForm" class="submit-btn-blue form-selector <?= $form === "offerForm" ? "form-active" : "" ?>">Offer</a>
        </div>
        <?php require __DIR__ . "/views/$form.php"; ?>
        <div class="rooms-admin-container">
            <h3>Rooms</h3>
            <div class="rooms-container">
                <?php foreach ($rooms as $room) : ?>
                    <div class="room-card text-dark-blue">
                        <img class="room-card-image" src=<?= "./assets/images/" . $room["images"][0]; ?> alt="cabin_snow_yellow">
                        <div class="room-card-text-content">
                            <div class="space-between">
                                <a class="text-dark-blue" href="<?= "admin.php?form=roomForm&edit=update&room=" . $room["id"]; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="<?= "app/deleteRoom.php?id=" . $room["id"] . "&images=" . implode(",", $room["images"]); ?>" class="text-error-red">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
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
                            <div class="space-between">
                                <a class="text-dark-blue" href="<?= "admin.php?form=activityForm&edit=update&activity=" . $activity["id"]; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="<?= "app/deleteActivity.php?id=" . $activity["id"] . "&image=" . $activity["image"]; ?>" class="text-error-red">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                            <div class="space-between">
                                <h3><?= $activity["name"]; ?></h3>
                                <h3><?= "$" . $activity["price"]; ?></h3>
                            </div>
                            <span><?= $activity["description"]; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="rooms-admin-container">
            <h3>Offers</h3>
            <div class="rooms-container">
                <?php foreach ($offers as $offer) : ?>
                    <div class="room-card text-dark-blue admin-offer-card">
                        <div>
                            <div class="space-between">
                                <a class="text-dark-blue" href="<?= "admin.php?form=offerForm&edit=update&offer=" . $offer["id"]; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="<?= "app/deleteOffer.php?id=" . $offer["id"]; ?>" class="text-error-red">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                            <div>
                                <h3><?= $offer["name"] ?></h3>
                                <div class="space-between text-offer-info">
                                    <div><?= "Discount %" . $offer["discount"] ?></div>
                                    <div><?= $offer["requirement"] . " - " . $offer["requirement_amount"] ?></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3>Offer is valid for</h3>
                            <?php foreach ($rooms as $room) :
                                if (in_array($room["id"], $offer["rooms"])) :
                            ?>
                                    <div class="text-offer-info"><?= $room["name"]; ?></div>
                            <?php
                                endif;
                            endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<?php require_once __DIR__ . "/views/footer.php"; ?>
