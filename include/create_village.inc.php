<?php
$db = mysqli_connect("localhost", "root", "123", "leviathalis");
if(!$db)
{
  exit("Verbindungsfehler: " . mysqli_connect_error());
}
mysqli_set_charset($db, 'utf8');

$sqlU = "SELECT * FROM users WHERE id = '$userId'";
$resultU = mysqli_query($db, $sqlU);
$rowU = mysqli_fetch_object($resultU);
$villageName = $rowU->name . "s Dorf";
// Daten in eine Tabelle abspeichern
$sqlU = "INSERT INTO villages
            (user, name)
            VALUES
            ('$userId','$villageName')";
?>