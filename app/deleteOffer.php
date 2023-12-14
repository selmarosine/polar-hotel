<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Deleting offer will also delete offer_room "ON DELETE CASCADE"
    $deleteOffer = $db->prepare("DELETE FROM offers WHERE id = :id");
    $deleteOffer->bindParam(":id", $id, PDO::PARAM_STR);
    $deleteOffer->execute();
}

redirect("/admin.php");
