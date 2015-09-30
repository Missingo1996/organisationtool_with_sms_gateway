<?php
session_start();

$registerform = "
<form action=\"#\" method=\"post\">

Benutzername:<br />
<input type=\"text\" size=\"24\" maxlength=\"50\" name=\"username\"><br />

E-Mail:<br />
<input type=\"text\" size=\"24\" maxlength=\"50\" name=\"mail\"><br /><br />

Vorname:<br />
<input type=\"text\" size=\"24\" maxlength=\"50\" name=\"firstname\"><br />

Nachname:<br />
<input type=\"text\" size=\"24\" maxlength=\"50\" name=\"lastname\"><br /><br />


Passwort:<br />
<input type=\"password\" size=\"24\" maxlength=\"50\" name=\"password\"><br />

Passwort wiederholen:<br />
<input type=\"password\" size=\"24\" maxlength=\"50\" name=\"password2\"><br />

<input type=\"submit\" value=\"Abschicken\">
</form>
";

//Wenn nicht angemeldet
if(!isset($_SESSION["username"]) && (!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["password2"]) || !isset($_POST["firstname"]) || !isset($_POST["lastname"]) || !isset($_POST["mail"])))
{
	echo $registerform;
	exit();
}

// Wenn angemeldet
if(isset($_SESSION["username"]))
{
	$url = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	header("Location: ../index.php");
	exit();
}

//Bei fehlerhafter Formulareingabe
if($_POST["username"] == "" || $_POST["password"] == "" || $_POST["password2"] == "" || $_POST["firstname"] == "" || $_POST["lastname"] == "" || $_POST["mail"] == "" || $_POST["password"] != $_POST["password2"])
{
	echo $registerform;
	echo "<p style=\"color: red\">Bitte alle Felder korrekt ausfüllen.</p>";
}
elseif(!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL))
{
	echo $registerform;
	echo "<p style=\"color: red\">Ungültige E-Mail-Adresse.</p>"; 
}
else
{
	require_once '../includes/db_connect.php';
	require_once './encrypt.php';
	
	$username = $_POST["username"];
	$password = encryptPassword($username, $_POST["password"]);
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$mail = $_POST["mail"];
	
	//Account bereits vorhanden?
	$result = $db->query("SELECT id FROM teacher WHERE username LIKE '$username' OR mail LIKE '$mail'");
	$rowCnt = $result->num_rows;
	
	if($rowCnt == 0)
	{
		//Wenn USER oder MAIL nicht vorhanden, eintragen
		$register = $db->query("INSERT INTO teacher (username, password, firstname, lastname, mail, permissions) VALUES ('$username', '$password', '$firstname', '$lastname', '$mail', '0')");
		
		//Eintrag erfolgreich
		if($register)
		{
			echo 	"Sie haben sich erfolgreich registriert.<br />
					Ihr Benutzername lautet <b>$username</b>.<br /><br />
					Zum Login? <a href=\"./login.php\">Login</a>";
		}
		else
		{
			echo "Registrieren fehlgeschlagen. Bitte wenden Sie sich an einen Administrator";
		}
	}
	else
	{
		echo $registerform;
		echo "<p style=\"color: red\">Benutzername und/oder E-Mail-Adresse schon vorhanden.</p>"; 
	}
}

?>