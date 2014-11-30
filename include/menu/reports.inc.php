<?php
echo "<h3>Deine Dörfer (" . mysqli_num_rows($result) . "):</h3><br/>
<table border=1>
<tr>
<td>Dorfname</td><td>Punkte</td>
</tr>";
$result = mysqli_query($db, $sql);
while ($dorf = mysqli_fetch_assoc($result))
{
    echo "<tr><td>" . $dorf["name"] . "</td><td>" . $dorf["points"] . "</td></tr>";
}
echo "</table>";
?>