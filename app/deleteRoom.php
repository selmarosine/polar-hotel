<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_GET["id"], $_GET["images"])) {
    try {
        $images = explode(",", $_GET["images"]);
        $id = $_GET["id"];

        $deleteRoom = $db->prepare("DELETE FROM rooms WHERE id = :id");

        $deleteRoom->bindParam(":id", $id, PDO::PARAM_STR);
        $deleteRoom->execute();

        foreach ($images as $image) {
            $path = __DIR__ . "/../assets/images/" . $image;

            if (file_exists($path)) {
                unlink($path);
            }
        }
    } catch (PDOException $e) {
        redirect("/admin.php");
    }
}

redirect("/admin.php");
