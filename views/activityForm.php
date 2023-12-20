<?php
$errorMessages = isset($_SESSION["adminFormErrors"]) ? $_SESSION["adminFormErrors"] : [];
unset($_SESSION["adminFormErrors"]);
?>
<form class="admin-form" action="<?= isset($activity) ? "/app/updateActivity.php" : "/app/insertActivity.php"; ?>" method="post" enctype="multipart/form-data">
    <?php if (!isset($activity)) : ?>
        <div class="column create-room-input">
            <label for="image-main" class="file-input-container center file-span-2">
                <i class="fa-solid fa-image"></i>
                <input class="file-input" required type="file" name="image" id="image-main" accept="image/png, image/jpg, image/jpeg">
            </label>
        </div>
    <?php endif; ?>
    <div class="flex-md name-price-container">
        <div class="column create-room-input">
            <label class="create-room-label" for="name">Activity</label>
            <input value="<?= isset($activity) ? $activity["name"] : ""; ?>" class="room-name-input" autocomplete="off" required type="text" name="name" id="name">
        </div>
        <div class="column create-room-input">
            <label class="create-room-label" for="price">Price</label>
            <input value="<?= isset($activity) ? $activity["price"] : ""; ?>" type="number" name="price" id="price" min="1" max="100" value="1">
        </div>
    </div>
    <div class="column create-room-input">
        <label class="create-room-label" for="description">Activity description</label>
        <textarea name="description" id="description" maxlength="500" required><?= isset($activity) ? $activity["description"] : ""; ?></textarea>
    </div>
    <?php require __DIR__ . "/errorMessages.php"; ?>
    <button class="submit-btn-blue" type="submit"><?= isset($activity) ? "Update activity" : "Add activity"; ?></button>
    <?php if (isset($activity)) : ?>
        <a href="admin.php?form=activityForm" class="submit-btn-blue cancel-update">Cancel update</a>
        <input type="hidden" name="id" value="<?= $activity["id"] ?>">
    <?php endif; ?>
</form>