<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

if ($_ENV["DEBUG"]) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}


$menu = [
    'main' => 'Main',
    'about' => 'About',
    // 'registration' => 'Registration',
];

$page = $_GET['action'] ?? 'main';
if (!file_exists("views/$page.php")) {
    $page = '404';
}

require_once 'layout/template.php';
