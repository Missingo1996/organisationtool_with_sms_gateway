<?php
session_start();

if(!isset($_SESSION["username"]))
{
	//Wenn nicht eingeloggt, Login anzeigen
	include("./login/login.html");
}
else{
	//Startseite des Users anzeigen
}
?>