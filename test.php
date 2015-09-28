<?php
echo $_SERVER['PHP_SELF'];
echo "<br />";
$uri   = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\');
echo $uri;
?>