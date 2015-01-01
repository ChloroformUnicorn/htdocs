<?php
include("../../../db.inc.php");
$villageId = $_GET["village"];
$orders = mysqli_query($db, "SELECT * FROM buildOrders WHERE villageId = '$villageId'");
if (mysqli_num_rows($orders) > 0) {
	date_default_timezone_set("Europe/Berlin");
	include("../../config.inc.php");

	echo "<table border=1>
		<tr><td><b>Ausbau</b></td><td><b>Zeit</b></td><td><b>Fertig am</b></td></tr>";

	// Abarbeitender Bauauftrag
	$order = mysqli_fetch_assoc($orders);
	$building = $order["building"];
	$getVillage = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
	$village = mysqli_fetch_assoc($getVillage);
	$newLevel = $village[$building] + 1;

	// Zeit formatieren
	$time = gmDate("H:i:s", $order["time"] - time());

	// Wann ist es fertig?
	$builtOnD = date("d.m.", $order["time"]);
	$builtOnT = date("H:i:s", $order["time"]);

	echo "<tr><td>".getName($building)." (Stufe ".$newLevel.")</td><td>".$time."</td><td>am ".$builtOnD.", um ".$builtOnT." Uhr</td></tr>";

	// Seite neuladen wenn ausgebaut
	if ($time == gmDate("H:i:s", 0))
	{
		echo "<script type='text/javascript'>
				setTimeout(function() {
					window.location.reload();
				},1000);
			  </script>";
  	}


	// In der Bauschleife wartenden Aufträge
	$x = mysqli_num_rows($orders);
	while ($order = mysqli_fetch_assoc($orders))
	{
		$building = $order["building"];

		// $newLevel
		$ordersB = mysqli_query($db, "SELECT * FROM buildOrders WHERE villageId = '$villageId' AND building = '$building'");
		$getVillageB = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
		$village = mysqli_fetch_assoc($getVillageB);
		$newLevel = $village[$building] + mysqli_num_rows($ordersB) - $x + 2;
		$x--;

		// Zeit formatieren
		$time = gmDate("H:i:s", $order["duration"]);

		// Wann ist es fertig?
		$builtOnD = date("d.m.", $order["time"]);
		$builtOnT = date("H:i:s", $order["time"]);
		// Bauschleifen-Reihe wird ausgegeben 
		echo "<tr><td>".getName($building)." (Stufe ".$newLevel.")</td><td>".$time."</td><td>am ".$builtOnD.", um ".$builtOnT." Uhr</td></tr>";
	}
	echo "</table><br />";
}