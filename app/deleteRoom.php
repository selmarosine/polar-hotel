<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_GET["id"], $_GET["images"])) {
    $images = explode(",", $_GET["images"]);
    $id = $_GET["id"];

    foreach ($images as $image) {
        $path = __DIR__ . "/../assets/images/" . $image;

        if (file_exists($path)) {
            unlink($path);
        }
    }

    $deleteRoom = $db->prepare("DELETE FROM rooms WHERE id = :id");

    $deleteRoom->bindParam(":id", $id, PDO::PARAM_STR);
    $deleteRoom->execute();
}

redirect("/admin.php");
