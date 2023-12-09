<?php
require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";

require __DIR__ . "/app/getActivities.php";
?>

<main class="room-main max-w-section">
    <div class="activity-cards-container">
        <?php foreach ($activities as $activity) : ?>
            <div class="activity-card">
                <img src=<?= "assets/images/" . $activity["image"] ?> alt="activity">
                <div class="activity-card-info">
                    <h3><?= $activity["activity"]; ?></h3>
                    <div class="price-sm"><?= "$" . $activity["price"]; ?></div>
                    <p><?= $activity["description"]; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once __DIR__ . "/views/footer.php"; ?>