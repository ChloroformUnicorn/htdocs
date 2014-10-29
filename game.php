<?php
session_start();
if (isset($_SESSION["id"]))
{
	echo "Willkommen im Spiel. Deine ID ist " . $_SESSION["id"];
}
else
{
	echo "Du bist nicht eingeloggt, du Hund!";
}

?>