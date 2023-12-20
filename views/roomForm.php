<?php
$errorMessages = isset($_SESSION["adminFormErrors"]) ? $_SESSION["adminFormErrors"] : [];
unset($_SESSION["adminFormErrors"]);
?>
<form class="admin-form" method="post" action="<?= isset($room) ? "/app/updateRoom.php" : "/app/insertRoom.php"; ?>" enctype="multipart/form-data">
    <?php if (!isset($room)) : ?>
        <div class="create-room-input room-gallery-grid">
            <label for="image-main" class="file-input-container center file-span-2">
                <i class="fa-solid fa-image"></i>
                <input class="file-input" required type="file" name="images[]" id="image-main" accept="image/png, image/jpg, image/jpeg">
            </label>
            <label for="images-secondary-left" class="file-input-container center">
                <i class="fa-solid fa-image"></i>
                <input class="file-input" required type="file" name="images[]" id="images-secondary-left" accept="image/png, image/jpg, image/jpeg">
            </label>
            <label for="images-secondary-right" class="file-input-container center">
                <i class="fa-solid fa-image"></i>
                <input class="file-input" required type="file" name="images[]" id="images-secondary-right" accept="image/png, image/jpg, image/jpeg">
            </label>
        </div>
    <?php endif; ?>
    <div class="flex-md name-price-container">
        <div class="column create-room-input">
            <label class="create-room-label" for="name">Room name</label>
            <input value="<?= isset($room) ? $room["name"] : ""; ?>" class="room-name-input" autocomplete="off" required type="text" name="name" id="name">
        </div>
        <div class="column create-room-input">
            <label class="create-room-label" for="price">Price + $1 per star</label>
            <input value="<?= isset($room) ? $room["price"] : ""; ?>" type="number" name="price" id="price" min="1" max="100" value="1">
        </div>
    </div>
    <div class="column create-room-input">
        <label class="create-room-label" for="description">Room description</label>
        <textarea name="description" id="description" maxlength="500" required><?= isset($room) ? $room["description"] : ""; ?></textarea>
    </div>
    <?php require __DIR__ . "/errorMessages.php"; ?>
    <button class="submit-btn-blue" type="submit"><?= isset($room) ? "Update room" : "Add room"; ?></button>
    <?php if (isset($room)) : ?>
        <a href="admin.php?form=roomForm" class="submit-btn-blue cancel-update">Cancel update</a>
        <input type="hidden" name="id" value="<?= $room["id"] ?>">
    <?php endif; ?>
</form>