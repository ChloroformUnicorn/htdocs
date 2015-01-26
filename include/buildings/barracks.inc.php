<h2>Kaserne</h2>
<br />
<script type="text/javascript">
	function maxEintragen(max) {
		document.getElementById("amount").value = max;
	}
</script>
<?php
$villageId = $_GET["village"];
$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$village = mysqli_fetch_assoc($res);

include "include/config.inc.php";

function calculateMaxRecruitable() {
	global $village, $price, $max;
	calculatePrice();
	// Verfügbare Rohstoffe
	$holzKap = $village["holz"];
	$steinKap = $village["stein"];
	$eisenKap = $village["eisen"];
	// Berechne die maximal bezahlbaren Einheiten
	$holzMax = intval($holzKap / $price["troop1"]["holz"]);
	$steinMax = intval($steinKap / $price["troop1"]["stein"]);
	$eisenMax = intval($eisenKap / $price["troop1"]["eisen"]);
	$max = min($holzMax, $steinMax, $eisenMax);
}

calculateMaxRecruitable();
calculateDuration($village);

if (isset($_POST["troop1"]))
{
	if ($_POST["amount"] <= $max)
	{
		$unit = "troop1";
		$now = time();
		$duration = $duration["troop1"];
		$amount = $_POST["amount"];
		// Rekrutierungsauftrag erstellen
		mysqli_query($db, "INSERT INTO recruitOrders
						(villageId, unit, time, duration, amount)
						VALUES
						('$villageId', '$unit', '$time', '$duration', '$amount')");
		// Ressourcen updaten
		$update = $village["holz"] - $price["troop1"]["holz"] * $_POST["amount"];
		mysqli_query($db, "UPDATE villages SET holz = '$update' WHERE id = '$villageId'");
		$update = $village["stein"] - $price["troop1"]["stein"] * $_POST["amount"];
		mysqli_query($db, "UPDATE villages SET stein = '$update' WHERE id = '$villageId'");
		$update = $village["eisen"] - $price["troop1"]["eisen"] * $_POST["amount"];
		mysqli_query($db, "UPDATE villages SET eisen = '$update' WHERE id = '$villageId'");
		echo "Rekrutierung durchgeführt.";
		calculateMaxRecruitable();
	}
	else
	{
		echo "Du hast nicht genügend Rohstoffe.";
	}
}
?>
<form method="post">
<table border=1 style="font-size: 14px;">
	<tr><td><b>Einheit</b></td><td><b>Bedarf</b></td><td><b>Vorh.</b></td><td><b>Rekrutieren</b></td></tr>
	<!-- Einheit: Höhlenmensch -->
	<tr><td>Höhlenmensch</td><td><img src="graphic/holz.png" width="16"><?php echo $price["troop1"]["holz"]; ?> <img src="graphic/stein.png" width="16"><?php echo $price["troop1"]["stein"]; ?> <img src="graphic/eisen.png" width="16"><?php echo $price["troop1"]["eisen"]; ?></td>
		<td><?php echo $village["troop1"] ?></td>
		<td><input size=4 id="amount" name="amount"> <span onclick="javascript:maxEintragen(<?php echo $max; ?>);">(max. <?php echo $max; ?>)</span></td></tr>
	<tr><td></td><td></td><td></td><td><input type="submit" value="Rekrutieren" name="troop1"></td></tr>
</table>
</form>