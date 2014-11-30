<?php
$villageName = $user->name . "s Dorf";
// Daten in eine Tabelle abspeichern
$sql = "INSERT INTO villages
            (user, name)
            VALUES
            ('$userId','$villageName')";
$res = mysqli_query($db, $sql);
?>