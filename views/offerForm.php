<?php
$errorMessages = isset($_SESSION["adminFormErrors"]) ? $_SESSION["adminFormErrors"] : [];
unset($_SESSION["adminFormErrors"]);

$successMessage = isset($_SESSION["adminFormSuccess"]) ? $_SESSION["adminFormSuccess"] : "";
unset($_SESSION["adminFormSuccess"]);
?>
<form class="admin-form" action="<?= isset($offer) ? "./app/updateOffer.php" : "./app/insertOffer.php"; ?>">
    <div class="flex-md name-price-container">
        <div class="column create-room-input">
            <label class="create-room-label" for="name">Discount name</label>
            <input value="<?= isset($offer) ? $offer["name"] : ""; ?>" class="room-name-input" autocomplete="off" required type="text" name="name" id="name">
        </div>
        <div class="column create-room-input">
            <label class="create-room-label" for="discount">Discount in %</label>
            <input value="<?= isset($offer) ? $offer["discount"] : ""; ?>" required type="number" name="discount" id="discount" min="0" max="100" value="0">
        </div>
    </div>
    <div class="create-room-label">Requirements</div>
    <div class="flex-md name-price-container">
        <div class="create-room-input flex-md">
            <select name="requirement" id="requirement">
                <option <?= isset($offer) && $offer["requirement"] === "days" ? "selected" : ""; ?> value="days">Days</option>
                <option <?= isset($offer) && $offer["requirement"] === "price" ? "selected" : ""; ?> value="price">Price</option>
            </select>
            <input value="<?= isset($offer) ? $offer["requirement_amount"] : ""; ?>" required type="number" name="amount" id="amount" min="1" value="1">
        </div>
    </div>
    <div class="create-room-label">Offer to be valid for</div>
    <div class="offers-admin-container">
        <?php foreach ($rooms as $room) : ?>
            <div>
                <input <?= isset($offer) && in_array($room["id"], $offer["rooms"]) ? "checked" : ""; ?> value="<?= $room["id"] ?>" type="checkbox" name="rooms[]">
                <?= $room["name"] ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (strlen($successMessage) > 0) : ?>
        <div class="success-message"><?= $successMessage; ?></div>
    <?php endif; ?>
    <?php require __DIR__ . "/errorMessages.php"; ?>
    <button class="submit-btn-blue" type="submit"><?= isset($offer) ? "Update discount" : "Add discount"; ?></button>
    <?php if (isset($offer)) : ?>
        <a href="admin.php?form=offerForm" class="submit-btn-blue cancel-update">Cancel update</a>
        <input type="hidden" name="id" value="<?= $offer["id"] ?>">
    <?php endif; ?>
</form>