<form class="admin-form" method="post" action="<?= isset($room) ? "/app/updateRoom.php" : "/app/insertRoom.php"; ?>" enctype="multipart/form-data">
    <?php if (!isset($room)) : ?>
        <div class="column create-room-input">
            <label for="images">Upload max 3 images</label>
            <input style="color: #fff;" required type="file" name="images[]" id="images" multiple="multiple" accept="image/png, image/jpg, image/jpeg">
        </div>
    <?php endif; ?>
    <div class="flex-md name-price-container">
        <div class="column create-room-input">
            <label for="name">Room name</label>
            <input value="<?= isset($room) ? $room["name"] : ""; ?>" class="room-name-input" autocomplete="off" required type="text" name="name" id="name">
        </div>
        <div class="column create-room-input">
            <label for="price">Price + $1 per star</label>
            <input value="<?= isset($room) ? $room["price"] : ""; ?>" type="number" name="price" id="price" min="1" max="100" value="1">
        </div>
    </div>
    <div class="column create-room-input">
        <label for="description">Room description</label>
        <textarea name="description" id="description" maxlength="500" required><?= isset($room) ? $room["description"] : ""; ?></textarea>
    </div>
    <button class="submit-btn-blue" type="submit"><?= isset($room) ? "Update room" : "Add room"; ?></button>
    <?php if (isset($room)) : ?>
        <a href="admin.php?form=roomForm" class="submit-btn-blue cancel-update">Cancel update</a>
        <input type="hidden" name="id" value="<?= $room["id"] ?>">
    <?php endif; ?>
</form>