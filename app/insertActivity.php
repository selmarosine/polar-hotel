<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_FILES["image"]) && calcImagesSize([$_FILES["image"]["size"]])) {
    $_SESSION["adminFormErrors"][] = "Image is to large max 20MB allowed";
    redirect("./../admin.php?form=activityForm");
}

if (isset($_POST["name"], $_POST["price"], $_POST["description"], $_FILES["image"])) {
    $image = $_FILES["image"];
    $imageName = guidv4() . "-" . $image["name"];
    $name = htmlspecialchars(trim(ucfirst($_POST["name"])));
    $price = $_POST["price"];
    $description = htmlspecialchars(trim($_POST["description"]));
    $activityId = guidv4();

    try {
        $insertActivity = $db->prepare("INSERT INTO activities (id, name, price, description, image) VALUES (:id, :name, :price, :description, :image)");
        $insertActivity->bindParam(":id", $activityId, PDO::PARAM_STR);
        $insertActivity->bindParam(":name", $name, PDO::PARAM_STR);
        $insertActivity->bindParam(":price", $price, PDO::PARAM_INT);
        $insertActivity->bindParam(":description", $description, PDO::PARAM_STR);
        $insertActivity->bindParam(":image", $imageName, PDO::PARAM_STR);
        $insertActivity->execute();

        move_uploaded_file($image["tmp_name"], __DIR__ . "/../assets/images/" . $imageName);
        redirect("./../admin.php?form=activityForm");
    } catch (PDOException $e) {
        $_SESSION["adminFormErrors"][] = "Error while saving new activity";
        redirect("./../admin.php?form=activityForm");
    }
}

$_SESSION["adminFormErrors"][] = "Not all fields are filled in, please try again.";
redirect("./../admin.php?form=activityForm");
