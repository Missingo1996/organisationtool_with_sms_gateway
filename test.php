<?php
include 'includes/db_config.php';
$DATABASE = DATABASE;
$create_database = "CREATE DATABASE IF NOT EXISTS $DATABASE";
echo $create_database;
echo "<br />Datenbank <b>$DATABASE </b> wurde erfolgreich angelegt.";
?>