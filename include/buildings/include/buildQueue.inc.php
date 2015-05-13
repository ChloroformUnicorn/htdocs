<?
require("../../../db.inc.php");
$villageId = $_GET["village"];
$orders = mysqli_query($db, "SELECT * FROM buildOrders WHERE villageId = '$villageId'");
if (mysqli_num_rows($orders) > 0) {
	require("../../config.inc.php");

	echo "<table border=1>
		<tr><td><b>Ausbau</b></td><td><b>Zeit</b></td><td><b>Fertig am</b></td></tr>";

	// Abarbeitender Bauauftrag
	$order = mysqli_fetch_assoc($orders);
	$building = $order["building"];
	$getVillage = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
	$village = mysqli_fetch_assoc($getVillage);
	$newLevel = $village[$building] + 1;

	// Zeit formatieren
	$init = $order["time"] - time();
	$hours = str_pad(floor($init / 3600), 2, "0", STR_PAD_LEFT);
	$minutes = str_pad(floor(($init / 60) % 60), 2, "0", STR_PAD_LEFT);
	$seconds = str_pad($init % 60, 2, "0", STR_PAD_LEFT);
	$duration = $hours.":".$minutes.":".$seconds;

	// Wann ist es fertig?
	$builtOnD = date("d.m.", $order["time"]);
	$builtOnT = date("H:i:s", $order["time"]);

	echo "<tr><td>".getName($building)." (Stufe ".$newLevel.")</td><td>".$duration."</td><td>am ".$builtOnD.", um ".$builtOnT." Uhr</td></tr>";

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

		$time = $order["time"];
		$otherOrders = mysqli_query($db, "SELECT * FROM buildOrders WHERE villageId = '$villageId' AND time < '$time'");
		if (mysqli_num_rows($otherOrders) > 0) {
			$init = $order["duration"];
		} else {
			$init = $order["time"] - time();
		}

		// Zeit formatieren
		$hours = str_pad(floor($init / 3600), 2, "0", STR_PAD_LEFT);
		$minutes = str_pad(floor(($init / 60) % 60), 2, "0", STR_PAD_LEFT);
		$seconds = str_pad($init % 60, 2, "0", STR_PAD_LEFT);
		$duration = $hours.":".$minutes.":".$seconds;

		// Wann ist es fertig?
		$builtOnD = date("d.m.", $order["time"]);
		$builtOnT = date("H:i:s", $order["time"]);

		// Bauschleifen-Reihe wird ausgegeben 
		echo "<tr><td>".getName($building)." (Stufe ".$newLevel.")</td><td>".$duration."</td><td>am ".$builtOnD.", um ".$builtOnT." Uhr</td></tr>";
	}
	echo "</table><br />";
}