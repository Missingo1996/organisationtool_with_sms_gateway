<?php
	$password = "admin";
	$username = "admin";
	echo hash('sha512', $password . $username);
?>