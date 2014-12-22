<?php
$villageId = $_GET["village"];
$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$village = mysqli_fetch_assoc($res);

function newLevel($building) {
	global $village;
	return $village[$building]+1;
}

$price =
	["main" => ["holz" => newLevel("main")*2+100, 
					"stein" => newLevel("main")*2+100, 
					"eisen" => newLevel("main")*2+100],
	"barracks" => ["holz" => newLevel("barracks")*2+100, 
					"stein" => newLevel("barracks")*2+100, 
					"eisen" => newLevel("barracks")*2+100],
	"res1" => ["holz" => newLevel("res1")*2+100, 
					"stein" => newLevel("res1")*2+100, 
					"eisen" => newLevel("res1")*2+100],
	"res2" => ["holz" => newLevel("res2")*2+100, 
					"stein" => newLevel("res2")*2+100, 
					"eisen" => newLevel("res2")*2+100],
	"res3" => ["holz" => newLevel("res3")*2+100, 
					"stein" => newLevel("res3")*2+100, 
					"eisen" => newLevel("res3")*2+100]
	];

function upgradeBuilding($building, $name) {
	global $update, $village, $price, $db, $villageId;
	$update["holz"] = $village["holz"]-$price[$building]["holz"];
	$update["stein"] = $village["stein"]-$price[$building]["stein"];
	$update["eisen"] = $village["eisen"]-$price[$building]["eisen"];
	if (($update["holz"] >= 0) AND ($update["stein"] >= 0) AND ($update["eisen"] >= 0))
	{
		$upgrade = mysqli_query($db, "UPDATE villages SET holz = '$update[holz]' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET stein = '$update[stein]' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET eisen = '$update[eisen]' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET '$building' = 'newLevel($building)' WHERE id = '$villageId'");
		echo $name . " auf Stufe " . newLevel($building) . " ausgebaut.";
	}
	else
	{
		echo "Dir stehen nicht genügend Ressourcen zu Verfügung.";
	}
}


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
	upgradeBuilding("res3", "Eisenmine");
}

$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$village = mysqli_fetch_assoc($res);
?>
<h2>Hauptgebäude</h2>
<br />
<table border=1>
	<tr>
		<td><b>Gebäude</b></td><td><b>Kosten</b></td><td><b>Bauen</b></td>
	</tr>
	<tr>
		<td>Hauptgebäude</td><td><?php echo $price["main"]["holz"] . " Holz, " . $price["main"]["stein"] . " Stein, " . $price["main"]["eisen"] . " Eisen"; ?></td>
		<td><form name="main" method="post">
		<input type="submit" name="main" value="Auf Stufe <?php echo newLevel("main") ?> ausbauen"></form></td>
	</tr>
	<tr>
		<td>Kaserne</td><td><?php echo $price["barracks"]["holz"] . " Holz, " . $price["barracks"]["stein"] . " Stein, " . $price["barracks"]["eisen"] . " Eisen"; ?></td>
		<td><form name="barracks" action="#" method="post">
		<input type="submit" name="barracks" value="Auf Stufe <?php echo newLevel("barracks") ?> ausbauen"></form></td>
	</tr>
	<tr>
		<td>Res1</td><td>blub</td>
		<td><form name="res1" method="post">
		<input type="submit" name="res1" value="Auf Stufe <?php echo $village["res1"]+1; ?> ausbauen"></form></td>
	</tr>
	<tr>
		<td>Res2</td><td>blub</td><td>
		<form name="res2" method="post">
		<input type="submit" name="res2" value="Auf Stufe <?php echo $village["res2"]+1; ?> ausbauen"></form></td>
	</tr>
	<tr>
		<td>Res3</td><td>blub</td><td>
		<form name="res3" method="post">
		<input type="submit" name="res3" value="Auf Stufe <?php echo $village["res3"]+1; ?> ausbauen"></form></td>
	</tr>
	<tr>
		<td>Hauptgebäude</td><td>blub</td><td>Auf Stufe <?php echo $village["main"]+1; ?> ausbauen</td>
	</tr>
	<tr>
		<td>Hauptgebäude</td><td>blub</td><td>Auf Stufe <?php echo $village["main"]+1; ?> ausbauen</td>
	</tr>
</table>