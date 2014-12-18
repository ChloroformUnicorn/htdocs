<?php
$res = mysqli_query($db, $usersVillages);
$village = mysqli_fetch_assoc($res);
$x0 = $village["x"];
$y0 = $village["y"];
echo "<table>
	<tr>
		<td>";
		$x=$x0-2; $y=$y0+2;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0-1; $y=$y0+2;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0; $y=$y0+2;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0+1; $y=$y0+2;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0+2; $y=$y0+2;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
	</tr>
	<tr>
		<td>";
		$x=$x0-2; $y=$y0+1;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0-1; $y=$y0+1;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0; $y=$y0+1;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0+1; $y=$y0+1;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0+2; $y=$y0+1;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
	</tr>
	<tr>
		<td>";
		$x=$x0-2; $y=$y0;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0-1; $y=$y0;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0; $y=$y0;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0+1; $y=$y0;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0+2; $y=$y0;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
	</tr>
	<tr>
		<td>";
		$x=$x0-2; $y=$y0-1;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0-1; $y=$y0-1;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0; $y=$y0-1;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0+1; $y=$y0-1;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0+2; $y=$y0-1;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
	</tr>
	<tr>
		<td>";
		$x=$x0-2; $y=$y0-2;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0-1; $y=$y0-2;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0; $y=$y0-2;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0+1; $y=$y0-2;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
		<td>";
		$x=$x0+2; $y=$y0-2;  
		$res = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
		$village = mysqli_fetch_assoc($res);
		echo $village["name"] . "</td>
	</tr>
	</table>";
?>