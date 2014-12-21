<?php
$villageId = $_GET["village"];
$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$building = mysqli_fetch_assoc($res);



// Gebäudestufen erhöhen
if (isset($_POST["MainAusbauen"]))
{
	$newLevel = $building["main"]+1;
	$holzUpdate = $village["holz"]-($newLevel*2+100);
	$steinUpdate = $village["stein"]-($newLevel*1.4+60);
	$eisenUpdate = $village["eisen"]-($newLevel*1.9+120);
	if (($holzUpdate >= 0) AND ($steinUpdate >= 0) AND ($eisenUpdate >= 0))
	{
		$upgrade = mysqli_query($db, "UPDATE villages SET holz = '$holzUpdate' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET stein = '$steinUpdate' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET eisen = '$eisenUpdate' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET main = '$newLevel' WHERE id = '$villageId'");
		echo "Hauptgebäude auf Stufe " . $newLevel . " ausgebaut.";
	}
	else
	{
		echo "Dir stehen nicht genügend Ressourcen zu Verfügung.";
	}
}
if (isset($_POST["Res1Ausbauen"]))
{
	$newLevel = $building["res1"]+1;
	$holzUpdate = $village["holz"]-($newLevel*2+100);
	$steinUpdate = $village["stein"]-($newLevel*1.4+60);
	$eisenUpdate = $village["eisen"]-($newLevel*1.9+120);
	if (($holzUpdate >= 0) AND ($steinUpdate >= 0) AND ($eisenUpdate >= 0))
	{
		$upgrade = mysqli_query($db, "UPDATE villages SET holz = '$holzUpdate' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET stein = '$steinUpdate' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET eisen = '$eisenUpdate' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET res1 = '$newLevel' WHERE id = '$villageId'");
		echo "Holzfäller auf Stufe " . $newLevel . " ausgebaut.";
	}
	else
	{
		echo "Dir stehen nicht genügend Ressourcen zu Verfügung.";
	}
}
if (isset($_POST["Res2Ausbauen"]))
{
	$newLevel = $building["res2"]+1;
	$holzUpdate = $village["holz"]-($newLevel*2+100);
	$steinUpdate = $village["stein"]-($newLevel*1.4+60);
	$eisenUpdate = $village["eisen"]-($newLevel*1.9+120);
	if (($holzUpdate >= 0) AND ($steinUpdate >= 0) AND ($eisenUpdate >= 0))
	{
		$upgrade = mysqli_query($db, "UPDATE villages SET holz = '$holzUpdate' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET stein = '$steinUpdate' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET eisen = '$eisenUpdate' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET res2 = '$newLevel' WHERE id = '$villageId'");
		echo "Steinwerk auf Stufe " . $newLevel . " ausgebaut.";
	}
	else
	{
		echo "Dir stehen nicht genügend Ressourcen zu Verfügung.";
	}
}
if (isset($_POST["Res3Ausbauen"]))
{
	$newLevel = $building["res3"]+1;
	$holzUpdate = $village["holz"]-($newLevel*2+100);
	$steinUpdate = $village["stein"]-($newLevel*1.4+60);
	$eisenUpdate = $village["eisen"]-($newLevel*1.9+120);
	if (($holzUpdate >= 0) AND ($steinUpdate >= 0) AND ($eisenUpdate >= 0))
	{
		$upgrade = mysqli_query($db, "UPDATE villages SET holz = '$holzUpdate' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET stein = '$steinUpdate' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET eisen = '$eisenUpdate' WHERE id = '$villageId'");
		$upgrade = mysqli_query($db, "UPDATE villages SET res3 = '$newLevel' WHERE id = '$villageId'");
		echo "Eisenmine auf Stufe " . $newLevel . " ausgebaut.";
	}
	else
	{
		echo "Dir stehen nicht genügend Ressourcen zu Verfügung.";
	}
}

$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$building = mysqli_fetch_assoc($res);
?>
<h2>Hauptgebäude</h2>
<br />
<table border=1>
	<tr>
		<td><b>Gebäude</b></td><td><b>Kosten</b></td><td><b>Bauen</b></td>
	</tr>
	<tr>
		<td>Hauptgebäude</td><td><?php $newLevel = $building["main"]+1; echo $newLevel*2+100 . " Holz, "; echo $newLevel*1.4+60 . " Stein, "; echo $newLevel*1.9+120 . " Eisen"; ?></td>
		<td><form name="MainAusbauen" action="#" method="post">
		<input type="submit" name="MainAusbauen" value="Auf Stufe <?php echo $newLevel; ?> ausbauen"></form></td>
	</tr>
	<tr>
		<td>Res1</td><td>blub</td><td><form name="Res1Ausbauen" action="#" method="post">
		<input type="submit" name="Res1Ausbauen" value="Auf Stufe <?php echo $building["res1"]+1; ?> ausbauen"></form></td>
	</tr>
	<tr>
		<td>Res2</td><td>blub</td><td><form name="Res2Ausbauen" action="#" method="post">
		<input type="submit" name="Res2Ausbauen" value="Auf Stufe <?php echo $building["res2"]+1; ?> ausbauen"></form></td>
	</tr>
	<tr>
		<td>Res3</td><td>blub</td><td><form name="Res3Ausbauen" action="#" method="post">
		<input type="submit" name="Res3Ausbauen" value="Auf Stufe <?php echo $building["res3"]+1; ?> ausbauen"></form></td>
	</tr>
	<tr>
		<td>Hauptgebäude</td><td>blub</td><td>Auf Stufe <?php echo $building["main"]+1; ?> ausbauen</td>
	</tr>
	<tr>
		<td>Hauptgebäude</td><td>blub</td><td>Auf Stufe <?php echo $building["main"]+1; ?> ausbauen</td>
	</tr>
</table>