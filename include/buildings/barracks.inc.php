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

// Rohstoffpreise 
$holzPreis = $village["barracks"]*5+10;
$steinPreis = $village["barracks"]*5+10;
$eisenPreis = $village["barracks"]*5+10;
// Verfügbare Rohstoffe
$holzKap = $village["holz"];
$steinKap = $village["stein"];
$eisenKap = $village["eisen"];
// Berechne die maximal bezahlbaren Einheiten
$holzMax = intval($holzKap / $holzPreis);
$steinMax = intval($steinKap / $steinPreis);
$eisenMax = intval($eisenKap / $eisenPreis);
$max = min($holzMax, $steinMax, $eisenMax);

if (isset($_POST["recruit"]))
{
	if ($_POST["amount"] <= $max)
	{
		$update = $village["troop1"] + $_POST["amount"];
		$recruit = mysqli_query($db, "UPDATE villages SET troop1 = '$update' WHERE id = '$villageId'");
		$update = $village["holz"] - $holzPreis * $_POST["amount"];
		$pay4it = mysqli_query($db, "UPDATE villages SET holz = '$update' WHERE id = '$villageId'");
		$update = $village["stein"] - $steinPreis * $_POST["amount"];
		$pay4it = mysqli_query($db, "UPDATE villages SET stein = '$update' WHERE id = '$villageId'");
		$update = $village["eisen"] - $eisenPreis * $_POST["amount"];
		$pay4it = mysqli_query($db, "UPDATE villages SET eisen = '$update' WHERE id = '$villageId'");
		echo "Rekrutierung durchgeführt.";
		$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
		$village = mysqli_fetch_assoc($res);
		// Rohstoffpreise 
		$holzPreis = $village["barracks"]*5+10;
		$steinPreis = $village["barracks"]*5+10;
		$eisenPreis = $village["barracks"]*5+10;
		// Verfügbare Rohstoffe
		$holzKap = $village["holz"];
		$steinKap = $village["stein"];
		$eisenKap = $village["eisen"];
		// Berechne die maximal bezahlbaren Einheiten
		$holzMax = intval($holzKap / $holzPreis);
		$steinMax = intval($steinKap / $steinPreis);
		$eisenMax = intval($eisenKap / $eisenPreis);
		$max = min($holzMax, $steinMax, $eisenMax);
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
	<tr><td>Höhlenmensch</td><td><?php echo $holzPreis; ?> Holz, <?php echo $steinPreis; ?> Stein, <?php echo $eisenPreis; ?> Eisen</td>
		<td><?php echo $village["troop1"] ?></td>
		<td><input size=4 id="amount" name="amount"> <span onclick="javascript:maxEintragen(<?php echo $max; ?>);">(max. <?php echo $max; ?>)</span></td></tr>
	<tr><td></td><td></td><td></td><td><input type="submit" value="Rekrutieren" name="recruit"></td></tr>
</table>
</form>