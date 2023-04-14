<?php

$hostname = $_ENV["DB_HOSTNAME"] ?? "localhost";
$username = $_ENV["DB_USERNAME"] ?? "test";
$password = $_ENV["DB_PASSWORD"] ?? "";
$database = $_ENV["DB_NAME"] ?? "testdb";

$mysqli = new mysqli($hostname, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}