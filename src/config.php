<?php

/**
 * Path: config.php
 * 
 * Config file for the project. Also contains the global variables.
 * 
 */

use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

// load all clases from classes folder
spl_autoload_register(function ($class_name) {
    require_once 'src/models/' . $class_name . '.php';
});

$dotenv = Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->safeLoad();

if ($_ENV["DEBUG"] == "True") {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
