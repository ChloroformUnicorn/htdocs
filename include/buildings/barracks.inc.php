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
	global $village, $troopPrice, $max;
	calculateTroopPrice();
	// Verfügbare Rohstoffe
	$holzKap = $village["holz"];
	$steinKap = $village["stein"];
	$eisenKap = $village["eisen"];
	// Berechne die maximal bezahlbaren Einheiten
	$holzMax = intval($holzKap / $troopPrice["troop1"]["holz"]);
	$steinMax = intval($steinKap / $troopPrice["troop1"]["stein"]);
	$eisenMax = intval($eisenKap / $troopPrice["troop1"]["eisen"]);
	$max = min($holzMax, $steinMax, $eisenMax);
}

calculateMaxRecruitable();

if (isset($_POST["recruit"]))
{
	if ($_POST["amount"] <= $max)
	{
		$update = $village["troop1"] + $_POST["amount"];
		mysqli_query($db, "UPDATE villages SET troop1 = '$update' WHERE id = '$villageId'");
		$update = $village["holz"] - $holzPreis * $_POST["amount"];
		mysqli_query($db, "UPDATE villages SET holz = '$update' WHERE id = '$villageId'");
		$update = $village["stein"] - $steinPreis * $_POST["amount"];
		mysqli_query($db, "UPDATE villages SET stein = '$update' WHERE id = '$villageId'");
		$update = $village["eisen"] - $eisenPreis * $_POST["amount"];
		mysqli_query($db, "UPDATE villages SET eisen = '$update' WHERE id = '$villageId'");
		echo "Rekrutierung durchgeführt.";
		$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
		$village = mysqli_fetch_assoc($res);
		calculateMaxRecruitable();
	}
	else
	{
		echo "Du hast nicht genügend Rohstoffe.";
	}
}
?>
<form name="recruit" method="post">
<table border=1 style="font-size: 14px;">
	<tr><td><b>Einheit</b></td><td><b>Bedarf</b></td><td><b>Vorh.</b></td><td><b>Rekrutieren</b></td></tr>
	<!-- Einheit: Höhlenmensch -->
	<tr><td>Höhlenmensch</td><td><?php echo $troopPrice["troop1"]["holz"]; ?> Holz, <?php echo $troopPrice["troop1"]["stein"]; ?> Stein, <?php echo $troopPrice["troop1"]["eisen"]; ?> Eisen</td>
		<td><?php echo $village["troop1"] ?></td>
		<td><input size=4 id="amount" name="amount"> <span onclick="javascript:maxEintragen(<?php echo $max; ?>);">(max. <?php echo $max; ?>)</span></td></tr>
	<tr><td></td><td></td><td></td><td><input type="submit" value="Rekrutieren" name="recruit"></td></tr>
</table>
</form>