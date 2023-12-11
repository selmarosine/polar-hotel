<form class="admin-form" action="<?= isset($activity) ? "/app/updateActivity.php" : "/app/insertActivity.php"; ?>" method="post" enctype="multipart/form-data">
    <?php if (!isset($activity)) : ?>
        <div class="column create-room-input">
            <label for="image">Upload a image</label>
            <input style="color: #fff;" required type="file" name="image" id="image" accept="image/png, image/jpg, image/jpeg">
        </div>
    <?php endif; ?>
    <div class="flex-md name-price-container">
        <div class="column create-room-input">
            <label for="activity">Activity</label>
            <input value="<?= isset($activity) ? $activity["activity"] : ""; ?>" class="room-name-input" autocomplete="off" required type="text" name="activity" id="activity">
        </div>
        <div class="column create-room-input">
            <label for="price">Price</label>
            <input value="<?= isset($activity) ? $activity["price"] : ""; ?>" type="number" name="price" id="price" min="1" max="100" value="1">
        </div>
    </div>
    <div class="column create-room-input">
        <label for="description">Activity description</label>
        <textarea name="description" id="description" maxlength="500" required><?= isset($activity) ? $activity["description"] : ""; ?></textarea>
    </div>
    <button class="submit-btn-blue" type="submit"><?= isset($activity) ? "Update activity" : "Add activity"; ?></button>
    <?php if (isset($activity)) : ?>
        <a href="admin.php?form=activityForm" class="submit-btn-blue cancel-update">Cancel update</a>
        <input type="hidden" name="id" value="<?= $activity["id"] ?>">
    <?php endif; ?>
</form>