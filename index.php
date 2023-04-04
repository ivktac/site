<?php

/**
 * Path: index.php
 * 
 * Main file of the project. Contains the main logic of the project.
 * 
 */

// TODO: Add likes/unlikes to the news
// TODO: Add comments to the news
// TODO: Add user profile page
// TODO: Upload site to the server

declare(strict_types=1);

$path = __DIR__ . '/src';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once 'config.php';
require_once 'functions.php';

$page = $_GET['action'] ?? 'main';
if (!file_exists("src/views/$page.php")) {
    $page = '404';
}

require_once 'layout/template.php';
