<?php
$errorMessages = isset($_SESSION["adminFormErrors"]) ? $_SESSION["adminFormErrors"] : [];
unset($_SESSION["adminFormErrors"]);
?>
<form class="admin-form" action="app/insertOffer.php">
    <div class="flex-md name-price-container">
        <div class="column create-room-input">
            <label class="create-room-label" for="name">Discount name</label>
            <input class="room-name-input" autocomplete="off" required type="text" name="name" id="name">
        </div>
        <div class="column create-room-input">
            <label class="create-room-label" for="discount">Discount in %</label>
            <input required type="number" name="discount" id="discount" min="0" max="100" value="0">
        </div>
    </div>
    <div class="create-room-label">Requirements</div>
    <div class="flex-md name-price-container">
        <div class="create-room-input flex-md">
            <select name="requirement" id="requirement">
                <option value="days">Days</option>
                <option value="price">Price</option>
            </select>
            <input required type="number" name="amount" id="amount" min="1" value="1">
        </div>
    </div>
    <div class="create-room-label">Offer to be valid for</div>
    <div class="offers-admin-container">
        <?php foreach ($rooms as $room) : ?>
            <div>
                <input value="<?= $room["id"] ?>" type="checkbox" name="rooms[]">
                <?= $room["name"] ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php require __DIR__ . "/errorMessages.php"; ?>
    <button class="submit-btn-blue" type="submit"><?= isset($discount) ? "Update discount" : "Add discount"; ?></button>
    <?php if (isset($discount)) : ?>
        <a href="admin.php?form=discountForm" class="submit-btn-blue cancel-update">Cancel update</a>
        <input type="hidden" name="id" value="<?= $discount["id"] ?>">
    <?php endif; ?>
</form>