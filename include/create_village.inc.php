<?php
// Name des ersten Dorfes generieren
$villageName = $user->name . "s Dorf";
// Koordinaten einstellen




// Datensatz der Dörfer des eingeloggten User
$res = mysqli_query($db, "SELECT * FROM villages ORDER BY id DESC LIMIT 1");
$newestVillage = mysqli_fetch_object($res);




// Daten in eine Tabelle abspeichern
$sql = "INSERT INTO villages
            (user, name)
            VALUES
            ('$userId','$villageName')";
$res = mysqli_query($db, $sql);
?>