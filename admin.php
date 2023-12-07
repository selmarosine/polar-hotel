<?php
require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";

if (!isset($_SESSION["admin"])) {
    redirect("/login.php");
}
?>

<main class="admin-main">
    Admin
</main>
<?php require_once __DIR__ . "/views/footer.php"; ?>