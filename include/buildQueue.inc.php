<?php
include("../db.inc.php");
$villageId = $_GET["village"];
$orders = mysqli_query($db, "SELECT * FROM buildOrders WHERE villageId = '$villageId'");
if (mysqli_num_rows($orders) > 0) {
	echo "<table border=1>
		<tr><td><b>Ausbau</b></td><td><b>Zeit</b></td><td><b>Fertig am</b></td></tr>";
	$timeTo = 1;
}
while ($order = mysqli_fetch_assoc($orders))
{
	$timeTo = gmDate("H:i:s", $order["whenToUpgrade"]-time());
	$builtOnD = gmDate("d.m.", $order["whenToUpgrade"]);
	$builtOnT = gmDate("H:i:s", $order["whenToUpgrade"]);
	$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
	$village = mysqli_fetch_assoc($res);
	$newLevel = $village[$order["building"]] + 1;
	echo "<tr><td>".$order["building"]." (".$newLevel.")</td><td>".$timeTo."</td><td>am ".$builtOnD.", um ".$builtOnT." Uhr</td></tr>";
	if ($timeTo == "00:00:00") {
		echo "<script type='text/javascript'> window.location.reload(); </script>";
	}
}
echo "</table><br />";