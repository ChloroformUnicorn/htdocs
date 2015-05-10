<?
// $village2, da es sonst das $village aus der game.php überschreiben würde
$getVillages = mysqli_query($db, "SELECT * FROM villages WHERE user = '$userId'");
echo "<h3>Deine Dörfer (".mysqli_num_rows($getVillages).")</h3><br/>
<table border=1>
<tr><td>Dorfname</td><td>Punkte</td></tr>";
while ($village2 = mysqli_fetch_assoc($getVillages))
{
    echo "<tr><td>" . $village2["name"] . "</td><td>" . $village2["points"] . "</td></tr>";
}
echo "</table>
	Du hast insgesamt " . getTotalUserPoints($userId) . " Punkte";