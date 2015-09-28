<?php
$password = "emre";
$salt = "sovic";
echo hash('sha512', $password . $salt);
?>