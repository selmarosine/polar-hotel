<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_FILES["images"]) && calcImagesSize($_FILES["images"]["size"])) {
    $_SESSION["adminFormErrors"][] = "Images are to large max 20MB allowed combined";
    redirect("./../admin.php?form=roomForm");
}

if (isset($_FILES["images"], $_POST["name"], $_POST["price"], $_POST["description"])) {
    $images = $_FILES["images"];

    $name = htmlspecialchars(trim(ucfirst($_POST["name"])));
    $price = intval($_POST["price"]);
    $description = htmlspecialchars(trim($_POST["description"]));
    $roomId = guidv4();

    $insertRoom = $db->prepare("INSERT INTO rooms (id, name, price, description) VALUES (:id, :name, :price, :description)");
    $insertRoom->bindParam(":id", $roomId, PDO::PARAM_STR);
    $insertRoom->bindParam(":name", $name, PDO::PARAM_STR);
    $insertRoom->bindParam(":price", $price, PDO::PARAM_INT);
    $insertRoom->bindParam(":description", $description, PDO::PARAM_STR);
    $insertRoom->execute();

    for ($idx = 0; $idx < 3; $idx++) {
        $fileName = formatImageName($images["name"][$idx]);
        $imageName = guidv4() . "-" . $fileName;

        $insertImage = $db->prepare("INSERT INTO image_room (room_id, image, position) VALUES (:room_id, :image, :position)");
        $insertImage->bindParam(":room_id", $roomId, PDO::PARAM_STR);
        $insertImage->bindParam(":image", $imageName, PDO::PARAM_STR);
        $insertImage->bindParam(":position", $idx, PDO::PARAM_INT); // Position need to update the correct image later on
        $insertImage->execute();

        move_uploaded_file($images['tmp_name'][$idx], __DIR__ . "/../assets/images/" . $imageName);
    }
    redirect("./../admin.php?form=roomForm");
}

$_SESSION["adminFormErrors"][] = "Not all fields are filled in, please try again";
redirect("./../admin.php?form=roomForm");
