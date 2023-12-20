<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_POST["name"], $_POST["price"], $_POST["description"], $_POST["id"])) {
    $name = htmlspecialchars(trim(ucfirst($_POST["name"])));
    $price = intval($_POST["price"]);
    $description = htmlspecialchars(trim($_POST["description"]));
    $id = $_POST["id"];
    $images = $_FILES["images"];

    $updateRoom = $db->prepare("UPDATE rooms SET name = :name, price = :price, description = :description WHERE id = :id");

    $updateRoom->bindParam(":name", $name, PDO::PARAM_STR);
    $updateRoom->bindParam(":price", $price, PDO::PARAM_INT);
    $updateRoom->bindParam(":description", $description, PDO::PARAM_STR);
    $updateRoom->bindParam(":id", $id, PDO::PARAM_STR);

    $updateRoom->execute();

    for ($idx = 0; $idx < 3; $idx++) {
        if (strlen($images["name"][$idx]) > 0) {
            // Delete old image
            $oldImage = $db->prepare("SELECT image FROM image_room WHERE room_id = :room_id AND position = :position");
            $oldImage->bindParam(":room_id", $id, PDO::PARAM_STR);
            $oldImage->bindParam(":position", $idx, PDO::PARAM_INT);
            $oldImage->execute();

            $oldImage = $oldImage->fetch();
            $oldImage = __DIR__ . "/../assets/images/" . $oldImage["image"];

            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            $fileName = formatImageName($images["name"][$idx]);
            $imageName = guidv4() . "-" . $fileName;

            $updateImage = $db->prepare("UPDATE image_room SET image = :image WHERE room_id = :room_id AND position = :position");
            $updateImage->bindParam(":room_id", $id, PDO::PARAM_STR);
            $updateImage->bindParam(":image", $imageName, PDO::PARAM_STR);
            $updateImage->bindParam(":position", $idx, PDO::PARAM_INT);
            $updateImage->execute();

            move_uploaded_file($images['tmp_name'][$idx], __DIR__ . "/../assets/images/" . $imageName);
        }
    }
}

redirect("/admin.php?form=roomForm");
