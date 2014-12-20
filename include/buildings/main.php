<?php
$villageId = $_GET["village"];
$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$building = mysqli_fetch_assoc($res);

// Gebäudestufen erhöhen
if (isset($_POST["MainAusbauen"]))
{
	$neueStufe = $building["main"]+1;
	$upgrade = mysqli_query($db, "UPDATE villages SET main = '$neueStufe' WHERE id = '$villageId'");
	echo "Hauptgebäude auf Stufe " . $neueStufe . " ausgebaut.";
}
if (isset($_POST["Res1Ausbauen"]))
{
	$neueStufe = $building["res1"]+1;
	$upgrade = mysqli_query($db, "UPDATE villages SET res1 = '$neueStufe' WHERE id = '$villageId'");
	echo "Res1 auf Stufe " . $neueStufe . " ausgebaut.";
}
if (isset($_POST["Res2Ausbauen"]))
{
	$neueStufe = $building["res2"]+1;
	$upgrade = mysqli_query($db, "UPDATE villages SET res2 = '$neueStufe' WHERE id = '$villageId'");
	echo "Res2 auf Stufe " . $neueStufe . " ausgebaut.";
}
if (isset($_POST["Res3Ausbauen"]))
{
	$neueStufe = $building["res3"]+1;
	$upgrade = mysqli_query($db, "UPDATE villages SET res3 = '$neueStufe' WHERE id = '$villageId'");
	echo "Res3 auf Stufe " . $neueStufe . " ausgebaut.";
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
		<td>Hauptgebäude</td><td>blub</td><td><form name="MainAusbauen" action="#" method="post">
		<input type="submit" name="MainAusbauen" value="Auf Stufe <?php echo $building["main"]+1; ?> ausbauen"></form></td>
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