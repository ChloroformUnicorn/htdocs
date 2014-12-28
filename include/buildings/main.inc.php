<?php
echo "<h2>Hauptgebäude</h2><br />";
date_default_timezone_set('Europe/Berlin');
$villageId = $_GET["village"];
$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$village = mysqli_fetch_assoc($res);


include("include/config.inc.php");
calculateDuration();

// Funktion welche die nächste Stufe eines Gebäudes ausgibt
function newLevel($building) {
	global $db, $village, $amountOfOrders;
	$orders = mysqli_query($db, "SELECT * FROM buildOrders WHERE building = '$building'");
	$amountOfOrders = mysqli_num_rows($orders);
	return $village[$building]+$amountOfOrders+1;
}
// Funktion die ein Update kauft (Ressourcen abzieht, Gebäudestufe erhöht)
function upgradeBuilding($building, $name) {
	global $update, $village, $price, $db, $villageId, $upgradeDate, $duration;
	$update["holz"] = $village["holz"]-$price[$building]["holz"];
	$update["stein"] = $village["stein"]-$price[$building]["stein"];
	$update["eisen"] = $village["eisen"]-$price[$building]["eisen"];
	if (($update["holz"] >= 0) AND ($update["stein"] >= 0) AND ($update["eisen"] >= 0))
	{
		mysqli_query($db, "UPDATE villages SET holz = '$update[holz]' WHERE id = '$villageId'");
		mysqli_query($db, "UPDATE villages SET stein = '$update[stein]' WHERE id = '$villageId'");
		mysqli_query($db, "UPDATE villages SET eisen = '$update[eisen]' WHERE id = '$villageId'");
		echo $name . " auf Stufe " . newLevel($building) . " ausgebaut.";
		// Vorherigen Bauauftrag finden
		$getLatestOrder = mysqli_query($db, "SELECT * FROM buildOrders WHERE villageId = '$villageId' ORDER BY id DESC");
		if (mysqli_num_rows($getLatestOrder) == 0)
		{
			$previousOrder = time();
		}
		else
		{
			$order = mysqli_fetch_assoc($getLatestOrder);
			$previousOrder = $order["time"];
		}
		$time = $previousOrder + $duration[$building];
		mysqli_query($db, "INSERT INTO buildOrders
							(villageId, building, time, duration)
							VALUES
							('$villageId', '$building', '$time', '$duration[$building]')");
	}
	else
	{
		echo "Dir stehen nicht genügend Ressourcen zu Verfügung.";
	}
}

calculatePrice();

function buildingRow($name, $building) {
	global $village, $price, $duration;
	echo "<tr>
		<td>".$name." (Stufe ".$village[$building].")</td>
		<td><img src='graphic/holz.png' height='16' style='vertical-align:middle;'>".$price[$building]['holz']." <img src='graphic/stein.png' height='16' style='vertical-align:middle;'>".$price[$building]['stein']." <img src='graphic/eisen.png' height='16' style='vertical-align:middle;'>".$price[$building]['eisen']."</td>
		<td>".gmDate("H:i:s", $duration[$building])."</td>
		<td><form name='".$building."' method='post'><input type='submit' name='".$building."' value='Auf Stufe ".newLevel($building)." ausbauen'></form></td>
		</tr>";
}

calculatePrice();

// Gebäudestufen erhöhen
if (isset($_POST["main"]))
{
	upgradeBuilding("main", "Hauptgebäude");
}
if (isset($_POST["barracks"]))
{
	upgradeBuilding("barracks", "Kaserne");
}
if (isset($_POST["res1"]))
{
	upgradeBuilding("res1", "Holzfäller");
}
if (isset($_POST["res2"]))
{
	upgradeBuilding("res2", "Steinbruch");
}
if (isset($_POST["res3"]))
{
	upgradeBuilding("res3", "Bergwerk");
}
// Werte updaten
$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$village = mysqli_fetch_assoc($res);
calculatePrice();

// Bauschleife
echo "<div id='buildQueue'>";
$orders = mysqli_query($db, "SELECT * FROM buildOrders WHERE villageId = '$villageId'");
if (mysqli_num_rows($orders) > 0) {

	echo "<table border=1>
		<tr><td><b>Ausbau</b></td><td><b>Zeit</b></td><td><b>Fertig am</b></td></tr>";

	date_default_timezone_set("Europe/Berlin");

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

	echo "<tr><td>".$building." (Stufe ".$newLevel.")</td><td>".$time."</td><td>am ".$builtOnD.", um ".$builtOnT." Uhr</td></tr>";

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
		echo "<tr><td>".$building." (Stufe ".$newLevel.")</td><td>".$time."</td><td>am ".$builtOnD.", um ".$builtOnT." Uhr</td></tr>";
	}
	echo "</table><br />";
}
echo "</div>";
// Gebäude Tabelle
echo "<table border=1>
	<tr><td><b>Gebäude</b></td><td><b>Kosten</b></td><td><b>Dauer</b></td><td><b>Bauen</b></td></tr>";
buildingRow("Hauptgebäude", "main");
if ($village["main"] >= 3)
{
	buildingRow("Kaserne", "barracks");
}
if ($village["main"] >= 5)
{
	buildingRow("Schmiede", "smith");
}
buildingRow("Tempel", "church");
buildingRow("Holzfäller", "res1");
buildingRow("Steinbruch", "res2");
buildingRow("Bergwerk", "res3");
buildingRow("Bauernhof", "farm");
buildingRow("Speicher", "store");
buildingRow("Wall", "wall");
echo "</table>";