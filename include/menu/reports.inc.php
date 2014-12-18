<?php
echo "<h3>Deine Dörfer (" . mysqli_num_rows($res) . "):</h3><br/>
<table border=1>
<tr><td>Dorfname</td><td>Punkte</td></tr>";
$res = mysqli_query($db, $usersVillages);
while ($village = mysqli_fetch_assoc($res))
{
    echo "<tr><td>" . $village["name"] . "</td><td>" . $village["points"] . "</td></tr>";
}
echo "</table>";
?>