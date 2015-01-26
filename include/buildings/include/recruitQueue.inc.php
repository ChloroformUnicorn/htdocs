<?php
require "../../../db.inc.php";
$villageId = $_GET["village"];
$orders = mysqli_query($db, "SELECT * FROM recruitOrders WHERE villageId = '$villageId'");
if (mysqli_num_rows($orders) > 0) {
	echo "<table border=1>
		<tr><td><b>Rekrutierung</b></td><td><b>Dauer</b></td><td><b>Fertigstellung</b></td></tr>";
	date_default_timezone_set("Europe/Berlin");
	while ($order = mysqli_fetch_assoc($orders))
	{
		$unit = $order["unit"];
		$amount = $order["amount"];
		$duration = gmDate("H:i:s", $order["amount"] * $order["duration"]);
		// Zeit formatieren
		$time = gmDate("H:i:s", $order["time"] - time());
		// Wann ist es fertig?
		$builtOnD = date("d.m.", $order["time"]);
		$builtOnT = date("H:i:s", $order["time"]);
		echo "<tr><td>".$amount." ".$unit."</td><td>".$duration."</td><td>am ".$builtOnD.", um ".$builtOnT." Uhr</td></tr>";
	}
	echo "</table><br>";
}