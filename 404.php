<?php

require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";
?>

<main class="room-main max-w-section page-not-found">
    <h1 class="not-found-title">404</h1>
    <p>Oops, the page you wanted is not found please return to start</p>
    <a href="index.php" class="submit-btn-blue not-found-back-link">
        <span>Back to start page</span>
        <i class="fa-solid fa-arrow-right center"></i>
    </a>
</main>

<?php require_once __DIR__ . "/views/footer.php"; ?>