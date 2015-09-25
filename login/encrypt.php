<?php
function encryptPassword($username, $password)
{
	return hash('sha512', $password . $salt);
}
?>