<?php

declare(strict_types=1);

use Dotenv\Dotenv;

session_start();

require_once 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

if ($_ENV["DEBUG"] == "True") {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

if ($_ENV["DB_HOSTNAME"] == "" || $_ENV["DB_USERNAME"] == "" || $_ENV["DB_PASSWORD"] == "" || $_ENV["DB_NAME"] == "") {
    die("Database connection failed: missing environment variables");
}

$conn = mysqli_connect($_ENV["DB_HOSTNAME"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$menu = [
    'main' => 'Main',
    'about' => 'About',
    // $_SESSION["user"] ? 'logout' : 'login' => $_SESSION["user"] ? 'Logout' : 'Login',
    'registration' => 'Registration', // TODO check if user is logged in and if not, show this menu item, otherwise hide it
];

$page = $_GET['action'] ?? 'main';
if (!file_exists("views/$page.php")) {
    $page = '404';
}

require_once 'layout/template.php';