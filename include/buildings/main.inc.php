<?php
echo "<h2>Hauptgebäude</h2><br />";
date_default_timezone_set('Europe/Berlin');
$villageId = $_GET["village"];
$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$village = mysqli_fetch_assoc($res);

// Funktion welche die nächste Stufe eines Gebäudes ausgibt
function newLevel($building) {
	global $village;
	return $village[$building]+1;
}
// Funcktion die ein Update kauft (Ressourcen abzieht, Gebäudestufe erhöht)
function upgradeBuilding($building, $name) {
	global $update, $village, $price, $db, $villageId, $upgradeDate;
	$update["holz"] = $village["holz"]-$price[$building]["holz"];
	$update["stein"] = $village["stein"]-$price[$building]["stein"];
	$update["eisen"] = $village["eisen"]-$price[$building]["eisen"];
	if (($update["holz"] >= 0) AND ($update["stein"] >= 0) AND ($update["eisen"] >= 0))
	{
		mysqli_query($db, "UPDATE villages SET holz = '$update[holz]' WHERE id = '$villageId'");
		mysqli_query($db, "UPDATE villages SET stein = '$update[stein]' WHERE id = '$villageId'");
		mysqli_query($db, "UPDATE villages SET eisen = '$update[eisen]' WHERE id = '$villageId'");
		echo $name . " auf Stufe " . newLevel($building) . " ausgebaut.";
		$now = time();
		$upgradeDate = time() + 10;
		mysqli_query($db, "INSERT INTO buildOrders
							(villageId, building, whenOrdered, whenToUpgrade)
							VALUES
							('$villageId', '$building', '$now', '$upgradeDate')");
	}
	else
	{
		echo "Dir stehen nicht genügend Ressourcen zu Verfügung.";
	}
}
// Preis zum Upgrade auf die nächste Stufe des Gebäudes berechnen
function calculatePrice() {
	global $price;
	$price =
		["main" => ["holz" => newLevel("main")*2+100, 
						"stein" => newLevel("main")*2+100, 
						"eisen" => newLevel("main")*2+100],
		"barracks" => ["holz" => newLevel("barracks")*2+100, 
						"stein" => newLevel("barracks")*2+100, 
						"eisen" => newLevel("barracks")*2+100],
		"smith" => ["holz" => newLevel("smith")*2+100, 
						"stein" => newLevel("smith")*2+100, 
						"eisen" => newLevel("smith")*2+100],
		"church" => ["holz" => newLevel("church")*2+100, 
						"stein" => newLevel("church")*2+100, 
						"eisen" => newLevel("church")*2+100],
		"res1" => ["holz" => newLevel("res1")*2+100, 
						"stein" => newLevel("res1")*2+100, 
						"eisen" => newLevel("res1")*2+100],
		"res2" => ["holz" => newLevel("res2")*2+100, 
						"stein" => newLevel("res2")*2+100, 
						"eisen" => newLevel("res2")*2+100],
		"res3" => ["holz" => newLevel("res3")*2+100, 
						"stein" => newLevel("res3")*2+100, 
						"eisen" => newLevel("res3")*2+100],
		"store" => ["holz" => newLevel("store")*2+100, 
						"stein" => newLevel("store")*2+100, 
						"eisen" => newLevel("store")*2+100],
		"farm" => ["holz" => newLevel("farm")*2+100, 
						"stein" => newLevel("farm")*2+100, 
						"eisen" => newLevel("farm")*2+100],
		"wall" => ["holz" => newLevel("wall")*2+100, 
						"stein" => newLevel("wall")*2+100, 
						"eisen" => newLevel("wall")*2+100]
		];
}

function buildingRow($name, $building) {
	global $village, $price;
	echo "<tr>
		<td>".$name." (".$village[$building].")</td>
		<td><img src='graphic/holz.png' height='16' style='vertical-align:middle;'>".$price[$building]['holz']." <img src='graphic/stein.png' height='16' style='vertical-align:middle;'>".$price[$building]['stein']." [E] ".$price[$building]['eisen']."</td>
		<td><form name='".$building."' method='post'><input type='submit' name='".$building."' value='Auf Stufe ". newLevel($building) ." ausbauen'></form></td>
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
$orders = mysqli_query($db, "SELECT * FROM buildOrders WHERE villageId = '$villageId'");
if (mysqli_num_rows($orders) > 0) {
	echo "<div id='buildQueue'></div>";
}
echo "<table border=1>
	<tr>
		<td><b>Gebäude</b></td><td><b>Kosten</b></td><td><b>Bauen</b></td>
	</tr>";
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