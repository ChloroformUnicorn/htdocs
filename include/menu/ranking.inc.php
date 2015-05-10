<?
echo "<h2>Rangliste</h2>";
$ranking = mysqli_query($db, "SELECT user, SUM(points) AS userPoints FROM villages GROUP BY user");
echo "<table border=1>
		<tr><td>Name</td><td>Punkte</td><td>Dörfer</td>";
foreach ($ranking as $ranking) {
	$userId = $ranking["user"];
	$user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM users WHERE id = '$userId'"));
	$amountOfVillages = mysqli_num_rows(mysqli_query($db, "SELECT * FROM villages WHERE user = '$userId'"));
	echo "<tr>
			<td>".$user["name"]."</td>
			<td>".$ranking["userPoints"]."</td>
			<td>".$amountOfVillages."</td>
		</tr>";
}
echo "</table>";