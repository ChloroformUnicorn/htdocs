<script type="text/javascript">
	var units = ["phalanx", "swordsman", "archer"];
	var max = [<? echo $village["phalanx"].", ".$village["swordsman"].", ".$village["archer"] ?>];
	
	function setToMax(setAll, unitId) {
		var inputfield = document.getElementById(units[unitId]);
		if (setAll) {
			// Wenn ausgewählt ist überall den Maximalwert einzutragen
			var everythingIsMax = true;
			for (var i = 0; i < units.length; i++) {
				if (document.getElementById(units[i]).value != max[i]) {
					everythingIsMax = false;
					break;
				}
			}
			if (everythingIsMax) {
				for (var i = 0; i < units.length; i++) {
					document.getElementById(units[i]).value = "";
				}
			} else {
				for (var i = 0; i < units.length; i++) {
					document.getElementById(units[i]).value = max[i];
				}
			}
		} else {
			// Wenn nur bei einer bestimmten Einheit der Maximalwert eingetragen werden soll
			if (inputfield.value == max[unitId]) {
				inputfield.value = "";
			} else {
				inputfield.value = max[unitId];
			}
		}
	}

	function sendTroops(villageId, target, type) {
		// Prüfen ob die Angaben gültig, nicht zu hoch und nicht negativ sind
		var validNumber = true;
		var amounts = [];
		for (var i = 0; i < units.length; i++) {
			var amount = document.getElementById(units[i]).value;
			if (amount == "") { amount = 0; }
			amounts.push(amount);
			var re = new RegExp("[^0-9]");
			if (isNaN(amount) || re.test(amount) || amount > max[i] || amount < 0) {
				validNumber = false;
				break;
			}
		}

		if (validNumber) {
			var url = "game.php?village="+villageId+"&screen=map&mode="+type+"&target="+target;
			for (var i = 0; i < units.length; i++) {
				url += "&" + units[i] + "=" + amounts[i];
			}
			window.location = url;
		} else {
			alert("Ein oder mehrere Werte sind ungültig oder zu hoch!");
		}
	}
</script>
<?
if (isset($_GET["target"])) {
	$targetId = $_GET["target"];
	$getVillage = mysqli_query($db, "SELECT * FROM villages WHERE id = '$targetId'");
	if (mysqli_num_rows($getVillage) < 1) {
		echo "<h2>Dieses Dorf existiert nicht.</h2>";
	} else {
		$target = mysqli_fetch_assoc($getVillage);
		$userId = $village["user"];
		$getUser = mysqli_query($db, "SELECT * FROM users WHERE id = '$userId'");
		$user = mysqli_fetch_assoc($getUser);
		echo "<h2>".$target["name"]."</h2>
			Besitzer: ".$target["name"]." (".getTotalPoints($user["id"]).")<br>
			Punkte: ".$target["points"]."<br><br>
			<div id='sendTroops'>
				<img src='graphic/troops/phalanx.png'> <input type='text' id='phalanx' name='phalanx' value=''> <span onclick= \"setToMax(false, 0)\" >(".$village["phalanx"].")</span> 
				<img src='graphic/troops/swordsman.png'> <input type='text' id='swordsman' name='swordsman'> <span onclick= \"setToMax(false, 1)\" >(".$village["swordsman"].")</span> 
				<img src='graphic/troops/archer.png'> <input type='text' id='archer' name='archer'> <span onclick= \"setToMax(false, 2)\" >(".$village["archer"].")</span>
				<p onclick='setToMax(true)'>(Alle Truppen einsetzen)</p><br>
				<button onclick='sendTroops(".$villageId.", ".$targetId.", \"attack\")'>Angreifen</button>
				<button onclick='sendTroops(".$villageId.", ".$targetId.", \"support\")'>Unterstützen</button>
			</div>";
	}
}