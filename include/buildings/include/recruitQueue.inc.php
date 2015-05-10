<?
require "../../../db.inc.php";
require "../../config.inc.php";
date_default_timezone_set("Europe/Berlin");
$villageId = $_GET["village"];
$recs = mysqli_query($db, "SELECT * FROM recruitOrders WHERE villageId = '$villageId'");
if (mysqli_num_rows($recs) > 0) {
	echo "<table border=1>
		<tr><td><b>Rekrutierung</b></td><td><b>Dauer</b></td><td><b>Fertigstellung</b></td></tr>";
	while ($rec = mysqli_fetch_assoc($recs))
	{
		$unit = $rec["unit"];
		$amount = $rec["amount"];
		$beginTime = $rec["beginTime"];
		$otherOrders = mysqli_query($db, "SELECT * FROM recruitOrders WHERE villageId = '$villageId' AND beginTime < '$beginTime'");
		if (mysqli_num_rows($otherOrders) > 0) {
			$init = $rec["totalAmount"] * $rec["duration"];
		} else {
			$init = ($rec["amount"] * $rec["duration"] + $rec["beginTime"]) - time();
		}
		// Dauer formatieren
		$hours = str_pad(floor($init / 3600), 2, "0", STR_PAD_LEFT);
		$minutes = str_pad(floor(($init / 60) % 60), 2, "0", STR_PAD_LEFT);
		$seconds = str_pad($init % 60, 2, "0", STR_PAD_LEFT);
		$duration = $hours.":".$minutes.":".$seconds;
		$fertigstellung = $rec["amount"] * $rec["duration"] + $rec["beginTime"];
		// Zeit formatieren
		$time = date("H:i:s", $fertigstellung - time());
		// Wann ist es fertig?
		$builtOnD = date("d.m.", $fertigstellung);
		$builtOnT = date("H:i:s", $fertigstellung);
		echo "<tr><td>$amount ".getName($unit)."</td><td>$duration</td><td>am $builtOnD, um $builtOnT Uhr</td></tr>";
	}
	echo "</table><br>";
}