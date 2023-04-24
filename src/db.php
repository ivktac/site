<?php

$hostname = $_ENV["DB_HOST"] ?? "localhost";
$username = $_ENV["DB_USER"] ?? "test";
$password = $_ENV["DB_PASSWORD"] ?? "";
$database = $_ENV["DB_NAME"] ?? "testdb";

$mysqli = new mysqli($hostname, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}