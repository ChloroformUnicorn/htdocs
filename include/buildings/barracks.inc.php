<script type="text/javascript">
	function maxEintragen(max) {
		document.getElementById("amount").value = max;
	}
</script>
<h2>Kaserne</h2><br>
<?
$villageId = $_GET["village"];
$getVillage = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$village = mysqli_fetch_assoc($getVillage);

// Rekrutier-Schleife
echo "<div id='recruitQueue'>";
$recs = mysqli_query($db, "SELECT * FROM recruitOrders WHERE villageId = '$villageId'");
if (mysqli_num_rows($recs) > 0) {
	echo "<table border=1>
		<tr><td><b>Rekrutierung</b></td><td><b>Dauer</b></td><td><b>Fertigstellung</b></td></tr>";
	while ($rec = mysqli_fetch_assoc($recs))
	{
		$unit = $rec["unit"];
		$amount = $rec["amount"];
		$timeUQueue = ($rec["amount"] - 1) * $rec["duration"];
		$timeUCurrent = $rec["duration"] - (time() - (($rec["totalAmount"] - $rec["amount"]) * $rec["duration"] + $rec["beginTime"]));
		// Dauer formatieren
		$init = ($rec["amount"] * $rec["duration"] + $rec["beginTime"]) - time();
		$hours = str_pad(floor($init / 3600), 2, "0", STR_PAD_LEFT);
		$minutes = str_pad(floor(($init / 60) % 60), 2, "0", STR_PAD_LEFT);
		$seconds = str_pad($init % 60, 2, "0", STR_PAD_LEFT);
		$duration = $hours.":".$minutes.":".$seconds;
		$fertigstellung = $rec["amount"] * $rec["duration"] + $rec["beginTime"];
		// Zeit formatieren
		$time = date("H:i:s", $fertigstellung - time());
		// Wann ist es fertig?
		$builtOnD = date("d.m.", $fertigstellung);
		$builtOnT = date("H:i:s", $fertigstellung);
		echo "<tr><td>$amount $unit</td><td>$duration</td><td>am $builtOnD, um $builtOnT Uhr</td></tr>";
	}
	echo "</table><br>";
}
echo "</div>";

capacity($village["farm"]);
calculatePrice();

function calculateMaxRecruitable($unit) {
	global $village, $price, $max, $farmCap;
	// Verfügbare Rohstoffe
	$holzKap = $village["holz"];
	$steinKap = $village["stein"];
	$eisenKap = $village["eisen"];
	// Berechne die maximal bezahlbaren Einheiten
	$holzMax = intval($holzKap / $price[$unit]["holz"]);
	$steinMax = intval($steinKap / $price[$unit]["stein"]);
	$eisenMax = intval($eisenKap / $price[$unit]["eisen"]);
	$max = min($holzMax, $steinMax, $eisenMax);
	// Berechne die Bauernhofkapazität
	$farmMax = $farmCap - ($price[$unit]["farmUnits"] + $village[$unit]);
	if ($max > $farmMax) {
		if ($farmMax < 0) {
			$max = 0;
		} else {
			$max = $farmMax;
		}
	}
}

calculateDuration($village);

if (isset($_POST["recruit"]))
{
	$troops = ["phalanx" => $_POST["phalanx"],
				"swordsman" => $_POST["swordsman"],
				"archer" => $_POST["archer"]];
	$troopNames = ["phalanx", "swordsman", "archer"];

	// Prüfen ob zu viele Truppen angefordert wurden
	$error_troops = false;
	for ($i = 0; $i < count($troopNames); $i++) {
		calculateMaxRecruitable($troopNames[$i]);
		$amount = $_POST[$troopNames[$i]];
		if (is_numeric($amount)) {
			if ($_POST[$troopNames[$i]] > $max) {
				$error_troops = true;
			}
		} else {
			$troops[$troopNames[$i]] = 0;
		}
		if ($error_troops) {
			break;
		}
	}

	if (!$error_troops)
	{
		// Einheiten deklarieren
		$troops = ["phalanx" => $_POST["phalanx"],
					"swordsman" => $_POST["swordsman"],
					"archer" => $_POST["archer"]];
		$troopNames = ["phalanx", "swordsman", "archer"];

		for ($i = 0; $i < count($troopNames); $i++) {
			calculateMaxRecruitable($troopNames[$i]);
			$unit = $troopNames[$i];
			$troops[$unit];

			$otherOrders = mysqli_query($db, "SELECT * FROM recruitOrders WHERE villageId = '$villageId' ORDER BY beginTime DESC");
			if (mysqli_num_rows($otherOrders) < 1) {
				$beginTime = time();
			} else {
				$otherOrder = mysqli_fetch_assoc($otherOrders);
				$beginTime = $otherOrder["beginTime"] + $otherOrder["totalAmount"] * $otherOrder["duration"];
			}
			$durationVar = $duration[$unit];
			$amount = $_POST[$unit];
			// Rekrutierungsauftrag erstellen
			mysqli_query($db, "INSERT INTO recruitOrders
							(villageId, unit, beginTime, duration, amount, totalAmount)
							VALUES
							('$villageId', '$unit', '$beginTime', '$durationVar', '$amount', '$amount')");
			// Ressourcen updaten
			$update = $village["holz"] - $price[$unit]["holz"] * $troops[$unit];
			mysqli_query($db, "UPDATE villages SET holz = '$update' WHERE id = '$villageId'");
			$update = $village["stein"] - $price[$unit]["stein"] * $troops[$unit];
			mysqli_query($db, "UPDATE villages SET stein = '$update' WHERE id = '$villageId'");
			$update = $village["eisen"] - $price[$unit]["eisen"] * $troops[$unit];
			mysqli_query($db, "UPDATE villages SET eisen = '$update' WHERE id = '$villageId'");
			calculateMaxRecruitable($unit);
		}	
		echo "Rekrutierung durchgeführt.";	
	}
	else
	{
		echo "Du hast nicht genügend Rohstoffe. ";
	}
}

echo "<form method='post'>";

$recs = mysqli_query($db, "SELECT * FROM recruitOrders WHERE villageId = '$villageId' ORDER BY beginTime DESC");
if (mysqli_num_rows($recs) > 0)
{
	$rec = mysqli_fetch_assoc($recs);
	$fertigstellung = $rec["amount"] * $rec["duration"] + $rec["beginTime"];
	$nextUnit = ($rec["beginTime"] - time()) % $duration[$rec["unit"]];

	$nextUnit = time() - ($rec["beginTime"] + ($rec["totalAmount"] - $rec["amount"]) * $rec["duration"]);

	echo "<table border=1><tr><td><b>Rekrutierung der nächsten Einheit in</b></td><td>"
		. date("i:s", $nextUnit) . "</td></tr></table>";
}
?>
<table border=1>
	<tr><td><b>Einheit</b></td><td><b>Kosten</b></td><td><b>Dauer</b></td><td><b>Vorh.</b></td><td><b>Rekrutieren</b></td></tr>
	<!-- Einheit: Phalanx -->
	<tr><td><img src="graphic/troops/phalanx.png" width="16">Phalanx</td>
		<td><img src="graphic/holz.png" width="16"><? echo $price["phalanx"]["holz"]; ?> <img src="graphic/stein.png" width="16"><? echo $price["phalanx"]["stein"]; ?> <img src="graphic/eisen.png" width="16"><? echo $price["phalanx"]["eisen"]; ?></td>
		<td><? echo date("i:s", $duration["phalanx"]); ?></td>
		<td><? echo $village["phalanx"] ?></td>
		<td><input size=5 id="amount" name="phalanx"> <span onclick="maxEintragen(<? calculateMaxRecruitable("phalanx"); echo $max; ?>);">(max. <? echo $max; ?>)</span></td>
	</tr>
	<!-- Einheit: Schwertkämpfer -->
	<tr><td><img src="graphic/troops/swordsman.png" width="16">Schwertkämpfer</td>
		<td><img src="graphic/holz.png" width="16"><? echo $price["swordsman"]["holz"]; ?> <img src="graphic/stein.png" width="16"><? echo $price["swordsman"]["stein"]; ?> <img src="graphic/eisen.png" width="16"><? echo $price["swordsman"]["eisen"]; ?></td>
		<td><? echo date("i:s", $duration["swordsman"]); ?></td>
		<td><? echo $village["swordsman"] ?></td>
		<td><input size=5 id="amount" name="swordsman"> <span onclick="maxEintragen(<? echo calculateMaxRecruitable("swordsman"); echo $max; ?>);">(max. <? echo $max; ?>)</span></td>
	</tr>
	<!-- Einheit: Bogenschütze -->
	<tr><td><img src="graphic/troops/archer.png" width="16">Bogenschütze</td>
		<td><img src="graphic/holz.png" width="16"><? echo $price["archer"]["holz"]; ?> <img src="graphic/stein.png" width="16"><? echo $price["archer"]["stein"]; ?> <img src="graphic/eisen.png" width="16"><? echo $price["archer"]["eisen"]; ?></td>
		<td><? echo date("i:s", $duration["archer"]); ?></td>
		<td><? echo $village["archer"] ?></td>
		<td><input size=5 id="amount" name="archer"> <span onclick="maxEintragen(<? echo calculateMaxRecruitable("archer"); echo $max; ?>);">(max. <? echo $max; ?>)</span></td>
	</tr>
	<tr><td></td><td></td><td></td><td></td><td><input type="submit" value="Rekrutieren" name="recruit"></td></tr>
</table>
</form>