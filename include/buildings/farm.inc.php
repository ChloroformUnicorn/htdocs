<?
echo "<h2>Bauernhof</h2><br>";

$villageId = $_GET["village"];
$res = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$village = mysqli_fetch_assoc($res);

capacity($village["farm"]);

echo "<table border=1>
		<tr>
			<td><b>Bauernhof Kapazität</b></td><td><b>Bauernhof Kapazität bei Stufe " . ($village["farm"] + 1) ."</b></td>
		</tr>
		<tr>
			<td>
				$farmCap Einheiten
			</td>";

capacity($village["farm"] + 1);

echo "		<td>
				$farmCap Einheiten
			</td>
		</tr>
	</table>";