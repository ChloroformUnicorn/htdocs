<?php
session_start();
// Logout wenn die Session abgelaufen ist
if ($_SESSION["id"]=="")
{
    header("Location: logout.php");
}
// Datenbankverbindung aufbauen
include("db.inc.php");
$userId = $_SESSION["id"];
// Datensatz des Users
$user = mysqli_fetch_object(mysqli_query($db, "SELECT * FROM users WHERE id = '$userId'"));
// Datensatz der Dörfer des eingeloggten User
$usersVillages = "SELECT * FROM villages WHERE user = '$userId'";
$res = mysqli_query($db, $usersVillages);
$village = mysqli_fetch_object($res);
?>
<html>
<head>
    <title>Spiel</title>
    <link rel="stylesheet" type="text/css" href="game.css" charset="utf-8" />
    <meta charset="utf-8">
</head>
<body>

<div class="outterWrapper">
    <div class="innerWrapper">
        <div id="sidebar">
            <a href="game.php?screen=overview"><img src="graphic/sidebar/overview.png"></a><br/>
            <a href="game.php?screen=reports"><img src="graphic/sidebar/reports.png"></a><br/>
            <a href="game.php?screen=map"><img src="graphic/sidebar/map.png"></a><br/>
            <a href="logout.php"><img src="graphic/sidebar/logout.png"></a><br/>
        </div>
        <div id="menu">
            <?php
            // Kein Dorf gefunden?
            if (!$village)
            {
                echo "Du hast ja noch gar keine Dörfer :O";
                include("include/create_village.inc.php");
            }
            // Spieler HAT Dörfer!
            else
            {
                // Übersichten
                if ($_GET["screen"] == "overview")
                {
                    include("include/menu/overview.inc.php");
                }
                // Berichte
                else if ($_GET["screen"] == "reports")
                {
                    include("include/menu/reports.inc.php");
                }
            }
            ?>
        </div>

        <div id="village">
            <div id="topbar">
                <?php
                $res = mysqli_query($db, $usersVillages);
                $village = mysqli_fetch_object($res);
                echo $village->name . " (" . $village->points . " Punkte)";
                ?>
            </div>
            <div id="overview">
                <?php
                // Weltkarte
                if ($_GET["screen"] == "map") {
                    include("include/menu/map.inc.php");
                // Dorfübersicht
                } else {
                    echo "<img style='margin: 25%; width: 10%; position: absolute;' src='graphic/buildings/main.png'>";
                    echo "<img style='margin: 50%; width: 10%; position: absolute;' src='graphic/buildings/main.png'>";
                }
                ?>
            </div>
            <div id="footer">
                Copyright Microsoft Corporation bitches
            </div>
        </div>
    </div>
</div>

</body>
</html>