<?php
session_start();

$loginform = "
<form action=\"#\" method=\"post\">
Benutzername:<br>
<input type=\"text\" size=\"24\" maxlength=\"50\" name=\"username\"><br><br>

Passwort:<br>
<input type=\"password\" size=\"24\" maxlength=\"50\" name=\"password\"><br>

<input type=\"submit\" value=\"Abschicken\">
</form>
<p>Noch nicht registiert? <a href=\"./register.php\">Registrieren</a></p>";

//Wenn nicht angemeldet
if(!isset($_SESSION["username"]) && (!isset($_POST["username"]) || !isset($_POST["password"])))
{
	echo $loginform;
	exit();
}

// Wenn angemeldet
if(isset($_SESSION["username"]))
{
	$url = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
	header("Location: http://$url$uri");
	exit();
}

//Anmelden
else
{
	require_once '../includes/db_connect.php';
	require_once './encrypt.php';
	
	$username = $_POST["username"];
	$password = encryptPassword($username, $_POST["password"]);
	
	$result = $db->query("SELECT username, password FROM teacher WHERE username LIKE '$username' LIMIT 1");
	$row = $result->fetch_object();
	
	if($row->password == $password)
	{
		//Login erfolgreich
		$_SESSION["username"] = $username;
		$url = $_SERVER['HTTP_HOST'];
		header("Location: http://$url");
	}
	else
	{
		//Login fehlgeschlagen
		echo $loginform;
		echo "<p style=\"color: red\">Benutzername und/oder Passwort ist falsch.</p>";
	}
}

?>