<?php
session_start();
if (!isset($_SESSION["install"]))
{
//MySQL INSTALLIEREN

include 'includes/db_config.php';

// Verbindungsvariable mit Zugangsdaten festlegen
@$db = new mysqli(HOST, USER, PASSWORD,'');

// Verbindung überprüfen
if (mysqli_connect_errno()) {
  printf("Verbindung zur Datenbank fehlgeschlagen: %s\n", mysqli_connect_error());
  $db->close();
  exit();
}

//Datenbanken anlegen
echo "<h2>MySQL Installation</h2>";
echo "<h3>Datenbanken werden angelegt...</h3>";

$DATABASE = DATABASE;
$create_database = "CREATE DATABASE IF NOT EXISTS $DATABASE";

if($db->query($create_database)){
	echo "Datenbank: <b>$DATABASE </b> wurde erfolgreich angelegt";
	$db->close();
	@$db = new mysqli(HOST, USER, PASSWORD, DATABASE);
}
else{
	echo "Datenbank: <b>$DATABASE </b> konnte nicht angelegt werden";
}

//Tabellen anlegen
echo "<br /><br /><h3>Tabellen werden angelegt...</h3>";

//USER-Tabelle
$table_user = "CREATE TABLE IF NOT EXISTS user (id INT(8) NOT NULL AUTO_INCREMENT, username VARCHAR(50) DEFAULT NULL, password VARCHAR(512) DEFAULT NULL, permissions INT(3) DEFAULT NULL, firstname VARCHAR(50) DEFAULT NULL, lastname VARCHAR(50) DEFAULT NULL, mail VARCHAR(150) DEFAULT NULL, course VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id))";
if($db->query($table_user)){
	echo "Tabelle: <b>user</b> wurde erfolgreich angelegt";
}
else{
	echo "Tabelle: <b>user</b> konnte nicht angelegt werden";
}

//STUDENTS-Tabelle
$table_students = "CREATE TABLE IF NOT EXISTS students (id INT(8) NOT NULL AUTO_INCREMENT, firstname VARCHAR(50) DEFAULT NULL, lastname VARCHAR(50) DEFAULT NULL, phone VARCHAR(30) DEFAULT NULL, ort VARCHAR(80) DEFAULT NULL, course VARCHAR(20) DEFAULT NULL, lastchange VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))";
if($db->query($table_students)){
	echo "Tabelle: <b>students</b> wurde erfolgreich angelegt";
}
else{
	echo "Tabelle: <b>students</b> konnte nicht angelegt werden";
}
//COURSE-Tabelle
$table_course = "CREATE TABLE IF NOT EXISTS course (id (INT(8) NOT NULL AUTO_INCREMENT, name VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))";
if($db->query($table_course)){
	echo "Tabelle: <b>course</b> wurde erfolgreich angelegt";
}
else{
	echo "Tabelle: <b>course</b> konnte nicht angelegt werden";
}

//ADMINISTRATOR-ACCOUNT ANLEGEN
$result = $db->query("SELECT id FROM user WHERE permissions LIKE '0'");
$admin = $result->num_rows;

if($admin == 0)
	{
	//Admin-Formular ausgeben
	}
$db->close();
?>