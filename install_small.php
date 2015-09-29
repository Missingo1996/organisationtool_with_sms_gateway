<?php
session_start();

//MySQL INSTALLIEREN
include 'includes/db_config.php';
include 'login/encrypt.php';

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

//TEACHER-Tabelle
$table_teacher = "CREATE TABLE IF NOT EXISTS teacher (id INT(8) NOT NULL AUTO_INCREMENT, username VARCHAR(50) DEFAULT NULL, password VARCHAR(512) DEFAULT NULL, permissions INT(3) DEFAULT NULL, firstname VARCHAR(50) DEFAULT NULL, lastname VARCHAR(50) DEFAULT NULL, mail VARCHAR(150) DEFAULT NULL, course VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id))";
if($db->query($table_teacher)){
	echo "Tabelle: <b>teacher</b> wurde erfolgreich angelegt<br />";
}
else{
	echo "Tabelle: <b>teacher</b> konnte nicht angelegt werden<br />";
}

//STUDENTS-Tabelle
$table_students = "CREATE TABLE IF NOT EXISTS students (id INT(8) NOT NULL AUTO_INCREMENT, firstname VARCHAR(50) DEFAULT NULL, lastname VARCHAR(50) DEFAULT NULL, phone VARCHAR(30) DEFAULT NULL, ort VARCHAR(80) DEFAULT NULL, course VARCHAR(20) DEFAULT NULL, lastchange VARCHAR(100) DEFAULT NULL, language VARCHAR(3) DEFAULT NULL, PRIMARY KEY(id))";
if($db->query($table_students)){
	echo "Tabelle: <b>students</b> wurde erfolgreich angelegt<br />";
}
else{
	echo "Tabelle: <b>students</b> konnte nicht angelegt werden<br />";
}
//COURSE-Tabelle
$table_course = "CREATE TABLE IF NOT EXISTS course (id INT(8) NOT NULL AUTO_INCREMENT, name VARCHAR(50) DEFAULT NULL, time INT(8) DEFAULT NULL, PRIMARY KEY(id))";
if($db->query($table_course)){
	echo "Tabelle: <b>course</b> wurde erfolgreich angelegt<br />";
}
else{
	echo "Tabelle: <b>course</b> konnte nicht angelegt werden<br />";
}
//Admin anlegen
$username = "admin";
$password = "admin";
$password = encryptPassword($username, $password);

$register = "INSERT INTO teacher (username, password) VALUES ('$username', '$password')";

$eintragen = $db->query($register);

if($eintragen == true)
{
	echo "<br />Benutzername : $username <br />";
	echo "Passwort: $password <br />";
}
$db->close();
?>