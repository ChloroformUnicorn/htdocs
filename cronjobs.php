<?php
include("db.inc.php");
date_default_timezone_set("Europe/Berlin");

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
$now = time() ;
$orders = mysqli_query($db, "SELECT * FROM buildOrders WHERE time < '$now'");
while ($order = mysqli_fetch_assoc($orders))
{
	$building = $order["building"];
	$villageId = $order["villageId"];
	$getVillage = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
	$village = mysqli_fetch_assoc($getVillage);
	$newLevel = $village[$building] + 1;
	mysqli_query($db, "UPDATE villages SET `$building` = '$newLevel' WHERE id = '$villageId'");
	$orderId = $order["id"];
	mysqli_query($db, "DELETE FROM buildOrders WHERE id = '$orderId'");
}

echo "Cronjobs durchgef&uuml;hrt";
// Seite neuladen
header("Refresh: 1; cronjobs.php");