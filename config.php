<?php

/**
 * Path: config.php
 * 
 * Config file for the project. Also contains the global variables.
 * 
 */

use Dotenv\Dotenv;

session_start();

require_once 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

if ($_ENV["DEBUG"] == "True") {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

$hostname = $_ENV["DB_HOSTNAME"] ?? "localhost";
$username = $_ENV["DB_USERNAME"] ?? "test";
$password = $_ENV["DB_PASSWORD"] ?? "";
$database = $_ENV["DB_NAME"] ?? "testdb";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$menu = [
    'main' => 'Main',
    'about' => 'About',
];

if (!isset($_SESSION["user"])) {
    $menu["registration"] = 'Registration';
}

$signinItem = isset($_SESSION["user"]) ? 'logout' : 'login';
$menu[$signinItem] = ucfirst($signinItem);