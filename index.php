<?php
session_start();

if(!isset($_SESSION["username"]))
{
	//Wenn nicht eingeloggt, Login anzeigen
	header("Location: ./login/login.php");
}
else{
	//Wenn eingeloggt, Startseite des Users anzeigen
	echo "Sie sind eingeloggt";
}
?>