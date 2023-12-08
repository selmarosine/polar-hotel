<?php
require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";


if (!isset($_SESSION["admin"])) {
    redirect("/login.php");
}

require __DIR__ . "/app/getRooms.php";

?>

<main class="admin-main">
    <section class="max-w-section">
        <form method="post" action="/app/insertRoom.php" enctype="multipart/form-data">
            <div class="column create-room-input">
                <label for="images">Upload max 3 images</label>
                <input style="color: #fff;" required type="file" name="images[]" id="images" multiple="multiple" accept="image/png, image/jpg, image/jpeg">
            </div>
            <div class="flex-md name-price-container">
                <div class="column create-room-input">
                    <label for="name">Room name</label>
                    <input class="room-name-input" autocomplete="off" required type="text" name="name" id="name">
                </div>
                <div class="column create-room-input">
                    <label for="price">Price + 10% per star</label>
                    <input type="number" name="price" id="price" min="1" max="100" value="1">
                </div>
            </div>
            <div class="column create-room-input">
                <label for="description">Room description</label>
                <textarea name="description" id="description" maxlength="500" required></textarea>
            </div>
            <button class="submit-btn-blue" type="submit">Add room</button>
        </form>
        <div class="rooms-container rooms-admin-container">
            <?php foreach ($rooms as $room) : ?>
                <div class="room-card text-dark-blue">
                    <img class="room-card-image" src=<?= "./assets/images/" . $room["images"][0]; ?> alt="cabin_snow_yellow">
                    <div class="room-card-text-content">
                        <div class="space-between">
                            <h3><?= $room["name"]; ?></h3>
                            <h3><?= "$" . $room["price"]; ?></h3>
                        </div>
                        <span><?= $room["description"]; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<?php require_once __DIR__ . "/views/footer.php"; ?>