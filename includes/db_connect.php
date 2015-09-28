<?php
include_once 'db_config.php';

// Verbindungsvariable mit Zugangsdaten festlegen
@$db = new mysqli(HOST, USER, PASSWORD, DATABASE);

// Verbindung überprüfen
if (mysqli_connect_errno()) {
  printf("Verbindung zur Datenbank fehlgeschlagen: %s\n", mysqli_connect_error());
  session_destroy();
  exit();
}
?>