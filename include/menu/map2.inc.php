<?
if (isset($_GET["target"])) {
	$target = $_GET["target"];
	$getVillage = mysqli_query($db, "SELECT * FROM villages WHERE id = '$target'");
	if (mysqli_num_rows($getVillage) < 1) {
		echo "<h2>Dieses Dorf existiert nicht.</h2>";
	} else {
		$village = mysqli_fetch_assoc($getVillage);
		$userId = $village["user"];
		$getUser = mysqli_query($db, "SELECT * FROM users WHERE id = '$userId'");
		$user = mysqli_fetch_assoc($getUser);
		echo "<h2>".$village["name"]."</h2>";
		echo "Besitzer: ".$user["name"]." (".getTotalPoints($user["id"]).")<br>";
		echo "Punkte: ".$village["points"];
	}
}