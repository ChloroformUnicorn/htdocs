<script type="text/javascript">
	var mouseX;
	var mouseY;
	$(function() {
		$("#map td").hover(function(e) {
			var td = $(this);
			if (td.attr("name") != "") {
				mouseX = e.pageX - 450;
				mouseY = e.pageY;
				$("#villageName").text(td.attr("name"));
				$("#villageOwner").text(td.attr("owner") + " (" + td.attr("ownerPoints") + ")");
				$("#villagePoints").text(td.attr("points"));
				$("#villageInfo").css({'top':mouseY,'left':mouseX}).show();
			}
		}, function() {
			$("#villageInfo").hide();
		});
		$("#map td").click(function() {
			var targetId = $(this).attr("id");
			if (targetId != "") {
				var villageId = <? echo $villageId; ?>;
				window.location = "game.php?village="+villageId+"&screen=map&target="+targetId;
			}
		});
	});
</script>
<div id="villageInfo">
	<table>
		<tr>
			<td id="villageName"></td>
		</tr>
		<tr>
			<td>Besitzer: </td><td id="villageOwner"></td>
		</tr>
		<tr>
			<td>Punkte: </td><td id="villagePoints"></td>
		</tr>
	</table>
</div>
<?
function village($x, $y) {
	global $db;
	$getVillage = mysqli_query($db, "SELECT * FROM villages WHERE x = '$x' AND y = '$y'");
	$village = mysqli_fetch_assoc($getVillage);
	$ownerId = $village["user"];
	$getUser = mysqli_query($db, "SELECT * FROM users WHERE id = '$ownerId'");
	$user = mysqli_fetch_assoc($getUser);
	echo "<td name='".$village["name"]."' owner='".$user["name"]."' points='".$village["points"]."' id='".$village["id"]."' ownerPoints='".getTotalUserPoints($user["id"])."'>".$village["name"]."</td>";
}

$x0 = $village["x"];
$y0 = $village["y"];

function villageTr($yShift) {
	global $x0, $y0;
	echo "<tr>";
		for ($i = -5; $i < 6; $i++) {
			village($x0+$i, $y0+$yShift);
		}
	echo "</tr>";
}

echo "<div id='map'><table style='margin-top: 50px'>";
for ($i = 4; $i > -5; $i--) {
	villageTr($i);
}
echo "</table></div>";
?>