<?
echo "<h2>Speicher</h2><br>";

date_default_timezone_set('Europe/Berlin');
$villageId = $_GET["village"];
$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$village = mysqli_fetch_assoc($res);

capacity($village["store"]);

echo "<table border=1>
		<tr>
			<td><b>Speicher-Kapazität</b></td><td><b>Speicher-Kapazität bei Stufe " . ($village["store"] + 1) ."</b></td>
		</tr>
		<tr>
			<td>
				<img src='graphic/holz.png' height='16' style='vertical-align:middle;'> $cap 
				<img src='graphic/stein.png' height='16' style='vertical-align:middle;'> $cap 
				<img src='graphic/eisen.png' height='16' style='vertical-align:middle;'> $cap
			</td>";

capacity($village["store"] + 1);

echo "		<td>
				<img src='graphic/holz.png' height='16' style='vertical-align:middle;'> $cap 
				<img src='graphic/stein.png' height='16' style='vertical-align:middle;'> $cap 
				<img src='graphic/eisen.png' height='16' style='vertical-align:middle;'> $cap
			</td>
		</tr>
	</table>";