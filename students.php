<?php
session_start();

if(!isset($_SESSION["username"]))
{
	//Wenn nicht eingeloggt, Login anzeigen
	header("Location: ./login/login.php");
	exit();
}
else{
	//Wenn eingeloggt, Students anfrage verarbeiten
	if(empty($_GET["students"]))
	{
		$students = "list";
	}
	else
	{
		$students = $_GET["students"];
	}
	
	//Schülerliste aufrufen, erreichbar über: students.php?students=list
	if($students == "list")
	{
		require_once "./students/list.php";
	}
	
	//Schülerprofil anzeigen, erreichbar über: students.php?students=show&id=1
	if($students == "show")
	{
		require_once "./students/show.php";
	}
}
?>