<?php
session_start();

if(!isset($_SESSION["username"]))
{
	//Wenn nicht eingeloggt, Login anzeigen
	$url = $_SERVER['HTTP_HOST'];
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$target = "login/login.php";
	header("Location: http://$url$uri/$target");
}
else{
	//Startseite des Users anzeigen
	echo "Sie sind eingeloggt";
}
?>