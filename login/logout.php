<?php
//Logout
$logout = session_destroy();
//Weiterleitung auf Startseite
if($logout){
	$url = $_SERVER['HTTP_HOST'];
	header("Location: http://$url");
	exit();
}
?>