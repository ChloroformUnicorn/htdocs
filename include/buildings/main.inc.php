<?php
echo "<h2>Hauptgebäude</h2><br>";

date_default_timezone_set('Europe/Berlin');
$villageId = $_GET["village"];
$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$village = mysqli_fetch_assoc($res);

calculateDuration();

// Funktion die ein Update kauft (Ressourcen abzieht, Gebäudestufe erhöht)
function upgradeBuilding($building) {
	global $update, $village, $price, $db, $villageId, $upgradeDate, $duration;
	$update["holz"] = $village["holz"]-$price[$building]["holz"];
	$update["stein"] = $village["stein"]-$price[$building]["stein"];
	$update["eisen"] = $village["eisen"]-$price[$building]["eisen"];
	if (($update["holz"] >= 0) AND ($update["stein"] >= 0) AND ($update["eisen"] >= 0))
	{
		mysqli_query($db, "UPDATE villages SET holz = '$update[holz]' WHERE id = '$villageId'");
		mysqli_query($db, "UPDATE villages SET stein = '$update[stein]' WHERE id = '$villageId'");
		mysqli_query($db, "UPDATE villages SET eisen = '$update[eisen]' WHERE id = '$villageId'");
		echo $building . " auf Stufe " . newLevel($building) . " ausgebaut.";
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

function buildingRow($building) {
	global $village, $price, $duration, $villageId, $token;
	echo "<tr>
		<td>".getName($building)." (Stufe ".$village[$building].")</td>
		<td><img src='graphic/holz.png' height='16' style='vertical-align:middle;'>".$price[$building]['holz']." <img src='graphic/stein.png' height='16' style='vertical-align:middle;'>".$price[$building]['stein']." <img src='graphic/eisen.png' height='16' style='vertical-align:middle;'>".$price[$building]['eisen']."</td>
		<td>".gmDate("H:i:s", $duration[$building])."</td>
		<td><a href='game.php?village=".$villageId."&screen=main&upgrade=".$building."&token=".$token."'>Auf Stufe ".newLevel($building)." ausbauen</a></td>
		</tr>";
}

calculatePrice();

// Gebäudestufen erhöhen
if (isset($_GET["upgrade"]))
{
	if ($_GET["token"] == $_SESSION["token"])
	{
		upgradeBuilding($_GET["upgrade"]);
	}
}

// Token generieren und in die Session speichern
$length = 10;
$token = bin2hex(openssl_random_pseudo_bytes($length));
$_SESSION["token"] = $token;

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
	$init = $order["time"] - time();
	$hours = str_pad(floor($init / 3600), 2, "0", STR_PAD_LEFT);
	$minutes = str_pad(floor(($init / 60) % 60), 2, "0", STR_PAD_LEFT);
	$seconds = str_pad($init % 60, 2, "0", STR_PAD_LEFT);
	$time = $hours.":".$minutes.":".$seconds;
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
		$init = $order["duration"];
		$hours = str_pad(floor($init / 3600), 2, "0", STR_PAD_LEFT);
		$minutes = str_pad(floor(($init / 60) % 60), 2, "0", STR_PAD_LEFT);
		$seconds = str_pad($init % 60, 2, "0", STR_PAD_LEFT);
		$time = $hours.":".$minutes.":".$seconds;
		// Wann ist es fertig?
		$builtOnD = date("d.m.", $order["time"]);
		$builtOnT = date("H:i:s", $order["time"]);
		// Bauschleifen-Reihe wird ausgegeben 
		echo "<tr><td>".getName($building)." (Stufe ".$newLevel.")</td><td>".$time."</td><td>am ".$builtOnD.", um ".$builtOnT." Uhr</td></tr>";
	}
	echo "</table><br />";
}
echo "</div>";
// Gebäude Tabelle
echo "<table border=1>
	<tr><td><b>Gebäude</b></td><td><b>Kosten</b></td><td><b>Dauer</b></td><td><b>Bauen</b></td></tr>";
buildingRow("main");
if ($village["main"] >= 3)
{
	buildingRow("barracks");
}
if ($village["main"] >= 5)
{
	buildingRow("smith");
}
buildingRow("church");
buildingRow("res1");
buildingRow("res2");
buildingRow("res3");
buildingRow("farm");
buildingRow("store");
buildingRow("wall");
echo "</table>";