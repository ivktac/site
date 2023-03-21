<?php

/**
 * Path: config.php
 * 
 * Config file for the project. Also contains the global variables.
 * 
 */

use Dotenv\Dotenv;
use SimpleCaptcha\Builder;

session_start();

require_once 'vendor/autoload.php';

// load all clases from classes folder
spl_autoload_register(function ($class_name) {
    $filename = "src/classes/" . $class_name . ".php";
    if (file_exists($filename)) {
        require_once $filename;
    }
});

$dotenv = Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->safeLoad();

if ($_ENV["DEBUG"] == "True") {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

$hostname = $_ENV["DB_HOSTNAME"] ?? "localhost";
$username = $_ENV["DB_USERNAME"] ?? "test";
$password = $_ENV["DB_PASSWORD"] ?? "";
$database = $_ENV["DB_NAME"] ?? "testdb";

$conn = new mysqli($hostname, $username, $password, $database);

$builder = Builder::create();
$builder->applyPostEffects = false;
$builder->applyScatterEffect = false;
$builder->applyNoise = false;
$builder->bgColor = "#ffffff";
$builder->build();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$menu = [
    'main' => 'Main',
    'about' => 'About',
];

if (!isset($_SESSION["user"])) {
    $menu["registration"] = 'Registration';
} else {
    $menu["profile"] = 'Profile';
}

$signinItem = isset($_SESSION["user"]) ? 'logout' : 'login';
$menu[$signinItem] = ucfirst($signinItem);

function check_allow_rights() {
    if (isset($_SESSION["user"])) {
        $user = unserialize($_SESSION["user"]);
        if (!$user->is_admin) {
            header("Location: index.php");
        }
    }
}