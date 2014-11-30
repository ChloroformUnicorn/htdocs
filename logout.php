<?php
session_start();
session_destroy();
echo "Du wurdest ausgeloggt.";
header("Refresh: 3; index.php");
?>