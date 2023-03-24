<?php

/**
 * Path: index.php
 * 
 * Main file of the project. Contains the main logic of the project.
 * 
 */

declare(strict_types=1);

require_once 'src/config.php';
require_once 'src/functions.php';

$page = $_GET['action'] ?? 'main';
if (!file_exists("src/views/$page.php")) {
    $page = '404';
}

require_once 'src/layout/template.php';