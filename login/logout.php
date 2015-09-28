<?php
session_start();

$logout = session_destroy();

//Weiterleitung auf Login
if($logout){
	$url = $_SERVER['HTTP_HOST'];
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$target = "login.php";
	header("Location: http://$url$uri/$target");
	exit();
}
else
{
	echo "Logout fehlgeschlagen. Bitte wenden Sie sich an einen Administrator";
}
?>