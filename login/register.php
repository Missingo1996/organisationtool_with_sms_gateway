<?php
session_start();

$registerform = "
<form action=\"#\" method=\"post\">

Benutzername:<br />
<input type=\"text\" size=\"24\" maxlength=\"50\" name=\"username\"><br /><br />

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
if(!isset($_SESSION["username"]) && (!isset($_POST["username"]) || !isset($_POST["password"])))
{
	echo $loginform;
	exit();
}

?>