<?php
require_once __DIR__ . "/app/autoload.php";
require_once __DIR__ . "/views/header.php";
require_once __DIR__ . "/views/navigation.php";

$errorMessages = isset($_SESSION["loginError"]) ? $_SESSION["loginError"] : [];
unset($_SESSION["loginError"]);
?>
<main class="admin-main center">
    <form action="app/login.php" method="post">
        <label for="password">
            <h3>Enter super secret password</h3>
        </label>
        <input required autocomplete="off" placeholder="••••••••" class="input-text <?= isset($_SESSION["loginError"]) ? "border-error-red" : ""; ?>" type="password" name="password" id="password">
        <?php require __DIR__ . "/views/errorMessages.php"; ?>
        <button class="submit-btn-blue" type="submit">Sign in</button>
    </form>
</main>
<?php require_once __DIR__ . "/views/footer.php"; ?>