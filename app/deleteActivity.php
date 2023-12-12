<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_GET["id"], $_GET["image"])) {
    $image = __DIR__ . "/../assets/images/" . $_GET["image"];
    $id = intval($_GET["id"]);

    if (!is_numeric($id)) {
        redirect("/admin.php");
    }

    if (file_exists($image)) {
        unlink($image);
    }

    $deleteRoom = $db->prepare("DELETE FROM activities WHERE id = :id");

    $deleteRoom->bindParam(":id", $id);
    $deleteRoom->execute();
}

redirect("/admin.php");
