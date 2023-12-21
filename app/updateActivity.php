<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_FILES["image"]) && calcImagesSize([$_FILES["image"]["size"]])) {
    $_SESSION["adminFormErrors"][] = "Image is to large max 20MB allowed";
    redirect("./../admin.php?form=activityForm");
}

if (isset($_POST["name"], $_POST["price"], $_POST["description"], $_POST["id"])) {
    $name = htmlspecialchars(trim(ucfirst($_POST["name"])));
    $price = intval($_POST["price"]);
    $description = htmlspecialchars(trim($_POST["description"]));
    $id = $_POST["id"];
    $imageSet = isset($_FILES["image"]) && strlen($_FILES["image"]["name"]) > 0 ? ", image = :image" : "";

    $updateRoom = $db->prepare("UPDATE activities SET name = :name, price = :price, description = :description $imageSet WHERE id = :id");

    if (isset($_FILES["image"]) && strlen($_FILES["image"]["name"]) > 0) {
        // Get old image name and delete it from /images
        $oldImage = $db->prepare("SELECT image FROM activities WHERE id = :id");
        $oldImage->bindParam(":id", $id, PDO::PARAM_STR);
        $oldImage->execute();
        $oldImage = $oldImage->fetch(PDO::FETCH_ASSOC);
        $oldImage = __DIR__ . "/../assets/images/" . $oldImage["image"];

        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        // add new image
        $image = $_FILES["image"];
        $imageName = guidv4() . "-" . $image["name"];
        $updateRoom->bindParam(":image", $imageName, PDO::PARAM_STR);

        move_uploaded_file($image["tmp_name"], __DIR__ . "/../assets/images/" . $imageName);
    }

    $updateRoom->bindParam(":name", $name, PDO::PARAM_STR);
    $updateRoom->bindParam(":price", $price, PDO::PARAM_INT);
    $updateRoom->bindParam(":description", $description, PDO::PARAM_STR);
    $updateRoom->bindParam(":id", $id, PDO::PARAM_STR);

    $updateRoom->execute();

    redirect("./../admin.php?form=activityForm");
}

$_SESSION["adminFormErrors"][] = "Not all fields are filled in, please try again.";
redirect("./../admin.php?form=activityForm");
