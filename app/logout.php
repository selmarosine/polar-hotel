<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.php";

unset($_SESSION["admin"]);

redirect(("../index.php"));
