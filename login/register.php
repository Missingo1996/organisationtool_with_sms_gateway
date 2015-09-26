<?php
include '../includes/db_connect.php';
include './encrypt.php';

$username = $_POST["username"];
$passwort = $_POST["password"];
$passwort2 = $_POST["password2"];

if($password != $password2 OR $username == "" OR $password == "")
    {
    echo "Eingabefehler. Bitte alle Felder korekt ausfüllen. <a href=\"eintragen.html\">Zurück</a>";
    exit;
    }
$password = encryptPassword($username, $password);

//Kontrolle ob USER bereits vorhanden
$result = $db->query("SELECT id FROM teacher WHERE username LIKE '$username'");

//Wieviel davon sind vorhanden?
$menge = $result->num_rows;

if($menge == 0)
    {
	$register = "INSERT INTO teacher (username, password) VALUES ('$username', '$password')";
    $eintragen = $db->query($register);

    if($eintragen == true)
        {
        echo "Sie haben sich erfolgreich registriert. Ihr Benutzername lautet <b>$username</b><a href=\"login.html\">Login</a>";
        }
    else
        {
        echo "Fehler beim Speichern des Benutzernames. <a href=\"register.html\">Zurück</a>";
        }
    }
else
    {
    echo "Benutzername schon vorhanden. <a href=\"register.html\">Zurück</a>";
    }
?>