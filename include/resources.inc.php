<?php
include("../db.inc.php");
$villageId = $_GET["village"];
$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$village = mysqli_fetch_assoc($res);

echo "<img src='graphic/holz.png' height='20' style='vertical-align: middle;'> " .$village["holz"] . " [S] " . $village["stein"] . 
	 " [E] " . $village["eisen"];