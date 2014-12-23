<?php
include("db.inc.php");

// Rohstoffproduktion
$villages = mysqli_query($db, "SELECT * FROM villages");
while ($village = mysqli_fetch_assoc($villages))
{
	$update1 = $village["res1"]*20 + $village["holz"];
	$update2 = $village["res2"]*20 + $village["stein"];
	$update3 = $village["res3"]*20 + $village["eisen"];
	$id = $village["id"];
	mysqli_query($db, "UPDATE villages SET holz = '$update1' WHERE id = '$id'");
	mysqli_query($db, "UPDATE villages SET stein = '$update2' WHERE id = '$id'");
	mysqli_query($db, "UPDATE villages SET eisen = '$update3' WHERE id = '$id'");
}

// Ausbauung von in Auftrag gegebenen Gebäuden
$orders = mysqli_query($db, "SELECT * FROM buildOrders");
$villages = mysqli_query($db, "SELECT * FROM villages");
$village = mysqli_fetch_assoc($villages);
while ($order = mysqli_fetch_assoc($orders))
{
	if ($order["whenToUpgrade"] < time())
	{
		$id = $order["id"];
		$building = $order["building"];
		$newLevel = $village[$building]+1;
		mysqli_query($db, "UPDATE villages SET `$building` = '$newLevel'");
		mysqli_query($db, "DELETE FROM buildOrders WHERE id = '$id'");
	}
}
echo "Cronjobs durchgef&uuml;hrt";
// Seite neuladen
header("Refresh: 1; cronjobs.php");