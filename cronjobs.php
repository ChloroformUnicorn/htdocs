<?php
include("db.inc.php");
$res = mysqli_query($db, "SELECT * FROM villages");
while ($village = mysqli_fetch_assoc($res))
{
	$update1 = $village["res1"] + $village["holz"];
	$update2 = $village["res2"] + $village["stein"];
	$update3 = $village["res3"] + $village["eisen"];
	$id = $village["id"];
	mysqli_query($db, "UPDATE villages SET holz = '$update1' WHERE id = '$id'");
	mysqli_query($db, "UPDATE villages SET stein = '$update2' WHERE id = '$id'");
	mysqli_query($db, "UPDATE villages SET eisen = '$update3' WHERE id = '$id'");
}
echo "Cronjob ausgef&uuml;hrt";