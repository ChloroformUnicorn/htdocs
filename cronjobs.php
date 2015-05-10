<?php
require("db.inc.php");
require("include/config.inc.php");
date_default_timezone_set("Europe/Berlin");

while (true)
{
	// Rohstoffproduktion
	$villages = mysqli_query($db, "SELECT * FROM villages");
	while ($village = mysqli_fetch_assoc($villages))
	{
		capacity($village["store"]);
		resourceProduction($village["res1"], $village["res2"], $village["res3"], $village["holz"], $village["stein"], $village["eisen"]);
		$id = $village["id"];
		// Holz
		if ($village["res1"] + $update1 > $cap) {
			mysqli_query($db, "UPDATE villages SET holz = '$cap' WHERE id = '$id'");
		} else {
			mysqli_query($db, "UPDATE villages SET holz = '$update1' WHERE id = '$id'");
		}
		// Stein
		if ($village["res2"] + $update1 > $cap) {
			mysqli_query($db, "UPDATE villages SET stein = '$cap' WHERE id = '$id'");
		} else {
			mysqli_query($db, "UPDATE villages SET stein = '$update2' WHERE id = '$id'");
		}
		// Eisen
		if ($village["res2"] + $update1 > $cap) {
			mysqli_query($db, "UPDATE villages SET eisen = '$cap' WHERE id = '$id'");
		} else {
			mysqli_query($db, "UPDATE villages SET eisen = '$update3' WHERE id = '$id'");
		}
	}

	// Ausbauung von in Auftrag gegebenen Gebäuden
	$now = time();
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

	// Rekrutierung
	$orders = mysqli_query($db, "SELECT * FROM recruitOrders");
	while ($order = mysqli_fetch_assoc($orders))
	{
		$orderId = $order["id"];
		if ($order["amount"] > 0)
		{
			$unit = $order["unit"];
			$villageId = $order["villageId"];
			$beginTime = $order["beginTime"];
			$olderOrders = mysqli_query($db, "SELECT * FROM recruitOrders WHERE villageId = '$villageId' AND beginTime > '$beginTime'");
			if ((($order["beginTime"] + $order["duration"]) < $now) && (mysqli_num_rows($olderOrders) < 1))
			{
				$getVillage = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
				$village = mysqli_fetch_assoc($getVillage);
				mysqli_query($db, "UPDATE villages SET `$unit` = `$unit` + 1 WHERE id = '$villageId'");
				mysqli_query($db, "UPDATE recruitOrders SET amount = amount - 1, beginTime = beginTime + duration WHERE id = '$orderId'");

				$orders = mysqli_query($db, "SELECT * FROM recruitOrders");
			}
		}
		else
		{
			mysqli_query($db, "DELETE FROM recruitOrders WHERE id = '$orderId'");
		}
	}

	echo "Cronjobs laufen ...";
	sleep(1);
}