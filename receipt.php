<?php

require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";

$successMessage = $_SESSION["bookingSuccess"] ?? "";
unset($_SESSION["bookingSuccess"]);

$receipt = $_SESSION["bookingReceipt"] ?? [];
unset($_SESSION["bookingReceipt"]);

$roomID = $_GET["room"] ?? "";

if (count($receipt) === 0) {
    redirect("index.php");
}
?>
<main class="room-main max-w-section">
    <?php if (strlen($successMessage) > 0) : ?>
        <div class="success-message"><?= $successMessage; ?></div>
    <?php endif; ?>
    <div class="receipt-container">
        <div class="receipt">
            <h3 class="receipt-title"><?= $receipt["island"] . " - " . $receipt["hotel"] ?></h3>
            <div class="line-break bg-dark"></div>
            <div class="space-between">
                <span>Stars</span>
                <span>
                    <?php for ($i = 0; $i < $receipt["stars"]; $i++) : ?>
                        <i class="fa-solid fa-star"></i>
                    <?php endfor; ?>
                </span>
            </div>
            <div class="space-between">
                <span>Check in</span>
                <span><?= $receipt["arrival_date"]; ?></span>
            </div>
            <div class="space-between">
                <span>Check out</span>
                <span><?= $receipt["departure_date"]; ?></span>
            </div>
            <?php foreach ($receipt["features"] as $activity) : ?>
                <div class="space-between">
                    <span><?= $activity["name"]; ?></span>
                    <span><?= "$" . $activity["cost"]; ?></span>
                </div>
            <?php endforeach; ?>
            <div class="space-between">
                <span>Total cost</span>
                <span><?= "$" . $receipt["total_cost"]; ?></span>
            </div>
            <div class="line-break bg-dark"></div>
            <button id="clipboard" class="submit-btn-blue">Copy receipt to clipboard</button>
        </div>
        <a class="submit-btn-blue" href="room.php?room=<?= $roomID; ?>">Back to room</a>
        <a class="submit-btn-blue" href="index.php">Back to start</a>
    </div>
</main>
<script>
    const receipt = JSON.stringify(<?= json_encode($receipt, JSON_PRETTY_PRINT); ?>, null, 2);
    const clipboardBtn = document.querySelector("#clipboard");
    const defaultText = clipboardBtn.textContent;

    clipboardBtn.addEventListener("click", () => {
        if (clipboardBtn.innerHTML !== defaultText) return;

        clipboardBtn.innerHTML = "<i class=\"fa-solid fa-check\"></i>";
        navigator.clipboard.writeText(receipt);

        setTimeout(() => {
            clipboardBtn.innerHTML = defaultText;
        }, 700)
    })
</script>

<?php require_once __DIR__ . "/views/footer.php"; ?>
