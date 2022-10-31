<?php

/**
 * @file
 * Common functions shared by every page.
 */

use PetBest\Database;

// $date1 = date("Y-m-d h:i:sa");
// $date2 = date("Y-m-d h:i:sa", strtotime('+12 hours'));
// $date3 = $date1->date_diff($date2);

require_once('config.php');

require_once('vendor/autoload.php');

$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4;";
$driver_options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

$pdo = new PDO($dsn, DB_USER, DB_PASS, $driver_options);

$database = Database::create($pdo);

session_start();
?>
