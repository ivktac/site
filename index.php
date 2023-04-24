<?php

/**
 * Path: index.php
 * 
 * Main file of the project. Contains the main logic of the project.
 * 
 */


declare(strict_types=1);


$path = __DIR__ . PATH_SEPARATOR . 'src';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

session_start();

$page = $_GET['action'] ?? 'main';
if (!file_exists("src/views/$page.php")) {
    $page = '404';
}

require_once 'config.php';

require_once 'layout/header.php';

require_once "views/$page.php";

require_once 'layout/footer.php';
