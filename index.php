<?php

/**
 * Path: index.php
 * 
 * Main file of the project. Contains the main logic of the project.
 * 
 */

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'src/config.php';

$page = $_GET['action'] ?? 'main';
if (!file_exists("src/views/$page.php")) {
    $page = '404';
}

require_once 'src/layout/template.php';