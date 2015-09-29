<?php
session_start();

$logout = session_destroy();

//Weiterleitung auf Login
if($logout){
	header("Location: ./login.php");
	exit();
}
else
{
	echo "Logout fehlgeschlagen. Bitte wenden Sie sich an einen Administrator";
}
?>