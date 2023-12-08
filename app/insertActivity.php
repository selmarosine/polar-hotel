<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_POST["activity"], $_POST["price"], $_POST["description"], $_FILES["image"])) {
    $image = $_FILES["image"];
    $imageName = uniqid() . "-" . $image["name"];
    $activity = htmlspecialchars(trim(ucfirst($_POST["activity"])));
    $price = $_POST["price"];
    $description = htmlspecialchars(trim($_POST["description"]));

    $insertActivity = $db->prepare("INSERT INTO activities (activity, price, description, image) VALUES (:activity, :price, :description, :image)");
    $insertActivity->bindParam(":activity", $activity);
    $insertActivity->bindParam(":price", $price);
    $insertActivity->bindParam(":description", $description);
    $insertActivity->bindParam(":image", $imageName);
    $insertActivity->execute();

    move_uploaded_file($image["tmp_name"], __DIR__ . "/../assets/images/" . $imageName);
}

redirect("/admin.php");
