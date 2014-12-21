<?php
$db = mysqli_connect("127.0.0.1", "root", "123", "leviathalis");
if(!$db)
{
  exit("Verbindungsfehler: " . mysqli_connect_error());
}
mysqli_set_charset($db, 'utf8');