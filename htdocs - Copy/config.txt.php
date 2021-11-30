<?php

/**
  * Configuration for database connection
  *
  */

$username = 'root';
$password = 'root';
$dbname = 'project4';
$host = 'localhost';
$port = 3306;
$dsn = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );