<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_FILES["images"], $_POST["name"], $_POST["price"], $_POST["description"])) {
    $images = $_FILES["images"];
    $imagesLength = count($images["name"]) <= 3 ? count($images["name"]) : 3;

    $name = htmlspecialchars(trim(ucfirst($_POST["name"])));
    $price = intval($_POST["price"]);
    $description = htmlspecialchars(trim($_POST["description"]));

    $insertRoom = $db->prepare("INSERT INTO rooms (name, price, description) VALUES (:name, :price, :description)");
    $insertRoom->bindParam(":name", $name, PDO::PARAM_STR);
    $insertRoom->bindParam(":price", $price, PDO::PARAM_INT);
    $insertRoom->bindParam(":description", $description, PDO::PARAM_STR);
    $insertRoom->execute();

    $roomId = $db->lastInsertId();

    for ($idx = 0; $idx < $imagesLength; $idx++) {
        $imageName = uniqid() . "-" . $images["name"][$idx];

        $insertImage = $db->prepare("INSERT INTO image_room (room_id, image) VALUES (:room_id, :image)");
        $insertImage->bindParam(":room_id", $roomId, PDO::PARAM_INT);
        $insertImage->bindParam(":image", $imageName, PDO::PARAM_STR);
        $insertImage->execute();

        move_uploaded_file($images['tmp_name'][$idx], __DIR__ . "/../assets/images/" . $imageName);
    }
}

redirect("/admin.php");
