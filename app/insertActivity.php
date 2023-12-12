<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_POST["activity"], $_POST["price"], $_POST["description"], $_FILES["image"])) {
    $image = $_FILES["image"];
    $imageName = guidv4() . "-" . $image["name"];
    $activity = htmlspecialchars(trim(ucfirst($_POST["activity"])));
    $price = $_POST["price"];
    $description = htmlspecialchars(trim($_POST["description"]));
    $activityId = guidv4();

    $insertActivity = $db->prepare("INSERT INTO activities (id, activity, price, description, image) VALUES (:id, :activity, :price, :description, :image)");
    $insertActivity->bindParam(":id", $activityId, PDO::PARAM_STR);
    $insertActivity->bindParam(":activity", $activity, PDO::PARAM_STR);
    $insertActivity->bindParam(":price", $price, PDO::PARAM_INT);
    $insertActivity->bindParam(":description", $description, PDO::PARAM_STR);
    $insertActivity->bindParam(":image", $imageName, PDO::PARAM_STR);
    $insertActivity->execute();

    move_uploaded_file($image["tmp_name"], __DIR__ . "/../assets/images/" . $imageName);
}

redirect("/admin.php");
