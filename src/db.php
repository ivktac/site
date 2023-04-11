<?php

$hostname = $_ENV["DB_HOSTNAME"] ?? "localhost";
$username = $_ENV["DB_USERNAME"] ?? "test";
$password = $_ENV["DB_PASSWORD"] ?? "";
$database = $_ENV["DB_NAME"] ?? "testdb";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (mysqli_errno($conn) != 0) {
    die("Connection failed: " . mysqli_connect_error());
}
