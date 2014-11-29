<?php
$db = mysqli_connect("localhost", "root", "123", "leviathalis");
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}
mysqli_set_charset($db, 'utf8');
?>