<?php require_once __DIR__ . "/../app/autoload.php"; ?>

<header>
    <a href="index.php" class="nav-logo">Polar Hotel</a>
    <aside id="a-side">
        <nav id="a-side-nav">
            <a href="activities.php">Activities</a>
            <a href="#">Offers</a>
            <?php if (isset($_SESSION["admin"])) : ?>
                <a href="admin.php">Admin</a>
            <?php endif; ?>
            <a href=<?= isset($_SESSION["admin"]) ? "app/logout.php" : "login.php" ?>><?= isset($_SESSION["admin"]) ? "Sign out" : "Sign in" ?></a>
        </nav>
    </aside>
    <div id="ham-menu-btn" class="ham-menu">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <nav class="desktop-nav">
        <a href="activities.php">Activities</a>
        <a href="#">Offers</a>
        <?php if (isset($_SESSION["admin"])) : ?>
            <a href="admin.php">Admin</a>
        <?php endif; ?>
        <a href=<?= isset($_SESSION["admin"]) ? "app/logout.php" : "login.php" ?>><?= isset($_SESSION["admin"]) ? "Sign out" : "Sign in" ?></a>
    </nav>
</header>