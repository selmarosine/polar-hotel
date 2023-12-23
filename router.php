<?php
// This will display 404.php if url path dose not exist only on localhost, .htaccess file for one.com liver server
// Start localhost server like this, "php -S localhost:8000 router.php"

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$file = __DIR__ . $path;

// if file exists then continue as usual else 404.php
if (is_file($file)) {
    return false;
} else {
    include("404.php");
}
