<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$page = $_GET['action'] ?? 'main';
if (!file_exists("views/$page.php")) {
  $page = '404';
}

require_once 'layout/template.php';

