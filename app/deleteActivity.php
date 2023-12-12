<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_GET["id"], $_GET["image"])) {
    $image = __DIR__ . "/../assets/images/" . $_GET["image"];
    $id = $_GET["id"];

    if (file_exists($image)) {
        unlink($image);
    }

    $deleteRoom = $db->prepare("DELETE FROM activities WHERE id = :id");

    $deleteRoom->bindParam(":id", $id, PDO::PARAM_STR);
    $deleteRoom->execute();
}

redirect("/admin.php");
