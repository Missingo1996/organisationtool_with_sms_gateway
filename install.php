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

//TEACHER-Tabelle
$table_teacher = "CREATE TABLE IF NOT EXISTS teacher (id INT(8) NOT NULL AUTO_INCREMENT, username VARCHAR(50) DEFAULT NULL, password VARCHAR(512) DEFAULT NULL, permissions INT(3) DEFAULT NULL, firstname VARCHAR(50) DEFAULT NULL, lastname VARCHAR(50) DEFAULT NULL, mail VARCHAR(150) DEFAULT NULL, course VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id))";
if($db->query($table_teacher)){
	echo "Tabelle: <b>teacher</b> wurde erfolgreich angelegt";
}
else{
	echo "Tabelle: <b>teacher</b> konnte nicht angelegt werden";
}

//STUDENTS-Tabelle
$table_students = "CREATE TABLE IF NOT EXISTS students (id INT(8) NOT NULL AUTO_INCREMENT, firstname VARCHAR(50) DEFAULT NULL, lastname VARCHAR(50) DEFAULT NULL, phone VARCHAR(30) DEFAULT NULL, ort VARCHAR(80) DEFAULT NULL, course VARCHAR(20) DEFAULT NULL, lastchange VARCHAR(100) DEFAULT NULL, language VARCHAR(3) DEFAULT NULL, PRIMARY KEY(id))";
if($db->query($table_students)){
	echo "Tabelle: <b>students</b> wurde erfolgreich angelegt";
}
else{
	echo "Tabelle: <b>students</b> konnte nicht angelegt werden";
}
//COURSE-Tabelle
$table_course = "CREATE TABLE IF NOT EXISTS course (id INT(8) NOT NULL AUTO_INCREMENT, name VARCHAR(50) DEFAULT NULL, time INT(8) DEFAULT NULL, PRIMARY KEY(id))";
if($db->query($table_course)){
	echo "Tabelle: <b>course</b> wurde erfolgreich angelegt";
}
else{
	echo "Tabelle: <b>course</b> konnte nicht angelegt werden";
}

$db->close();
$_SESSION["install"] = 1;
}
else{
include 'includes/db_connect.php';	
}





if($_SESSION["install"] == 1){
//ADMINISTRATOR-ACCOUNT ANLEGEN
$result = $db->query("SELECT id FROM user WHERE permissions LIKE '0'");
$admin = $result->num_rows;

	if($admin == 0)
	{
	//Admin-Formular ausgeben
	$_SESSION["install"] = 2;
	//Formular
	?>
		<form action="register.php" method="post">
		Dein Username:<br>
		<input type="text" size="24" maxlength="50" name="username"><br><br>

		Dein Passwort:<br>
		<input type="password" size="24" maxlength="50" name="password"><br>

		Passwort wiederholen:<br>
		<input type="password" size="24" maxlength="50" name="password2"><br>
		
		Dein Vorname:<br>
		<input type="text" size="24" maxlength="50" name="firstname"><br><br>
		
		Dein Nachname:<br>
		<input type="text" size="24" maxlength="50" name="lastname"><br><br>
		
		Deine E-Mail-Adresse:<br>
		<input type="text" size="24" maxlength="50" name="mail"><br><br>

		<input type="submit" value="Abschicken">
		</form>
	<?php
	}
}
else{
	session_destroy;
}





if($_SESSION["install"] == 2){
include 'login/encrypt.php';

$username = $_POST["username"];
$passwort = $_POST["password"];
$passwort2 = $_POST["password2"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$mail = $_POST["mail"];

if($password != $password2 OR $username == "" OR $password == "")
    {
    echo "Eingabefehler. Bitte alle Felder korekt ausfüllen. <a href=\"install.php\">Zurück</a>";
	$_SESSION["install"] = 1;
    exit;
    }
$password = encryptPassword($username, $password);

$register = "INSERT INTO teacher (username, password, firstname, lastname, mail) VALUES ('$username', '$password', '$firstname', '$lastname', '$mail')";
$eintragen = $db->query($register);

if($eintragen == true)
{
	echo "Sie haben sich erfolgreich registriert. Ihr Benutzername lautet <b>$username</b><a href=\"login.html\">Login</a>";
}
else
{
	echo "Fehler beim Speichern des Benutzernames. <a href=\"install.php\">Zurück</a>";
	$_SESSION["install"] = 1;
}
session_destroy();
}
?>