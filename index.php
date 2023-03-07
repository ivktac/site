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

// TODO use global PDO??? or just in the the registration.php file add `$conn = mysqli_connect(...);`

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
