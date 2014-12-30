<?php
include("db.inc.php");
include("include/config.inc.php");
date_default_timezone_set("Europe/Berlin");

while (true)
{
	// Rohstoffproduktion
	$villages = mysqli_query($db, "SELECT * FROM villages");
	while ($village = mysqli_fetch_assoc($villages))
	{
		resourceProduction($village["res1"], $village["res2"], $village["res3"], $village["holz"], $village["stein"], $village["eisen"]);
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
	sleep(1);
}