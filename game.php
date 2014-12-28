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
$villageId = $_GET["village"];
// Datensatz des Users
$user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM users WHERE id = '$userId'"));
// Datensatz der Dörfer des eingeloggten User
$usersVillages = "SELECT * FROM villages WHERE user = '$userId'";
$res = mysqli_query($db, $usersVillages);
$village = mysqli_fetch_assoc($res);
?>
<html>
<head>
    <title>Spiel</title>
    <link rel="stylesheet" type="text/css" href="game.css" charset="utf-8" />
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
        setInterval(function() { 
            // Ressourcen-Anzeige updaten
            $.ajax({ 
              url:'include/resources.inc.php?village=<?php echo $villageId; ?>', 
              type:"POST", 
              async:true, 
              data:{}, 
              success:function(data) { 
                $("#resources").html(data);
              } 
            }); 
            // Bauschleife updaten
            $.ajax({ 
              url:'include/buildings/include/buildQueue.inc.php?village=<?php echo $villageId; ?>', 
              type:"POST", 
              async:true, 
              data:{}, 
              success:function(data) { 
                $("#buildQueue").html(data);
              } 
            });     
        },1000);

        $(document).ready(function() {
            $("#sidebar img").mouseenter(function() {
                $(this).fadeTo("fast", 0.75);
            });
            $("#sidebar img").mouseleave(function() {
                $(this).fadeTo("fast", 1);
            });
        });
    </script>
</head>
<body>
<div class="outterWrapper">
    <div class="innerWrapper">
        <div id="sidebar">
            <a href="game.php?village=<?php echo $villageId; ?>&screen=overview"><img src="graphic/sidebar/overview.png"></a><br/>
            <a href="game.php?village=<?php echo $villageId; ?>&screen=reports"><img src="graphic/sidebar/reports.png"></a><br/>
            <a href="game.php?village=<?php echo $villageId; ?>&screen=map"><img src="graphic/sidebar/map.png"></a><br/>
            <a href="logout.php"><img src="graphic/sidebar/logout.png"></a><br/>
        </div>
        <div id="menu">
            <?php
            // Kein Dorf gefunden?
            if (!$village)
            {
                echo "Du hast ja noch gar kein Dorf :O";
                include("include/create_village.inc.php");
            }
            // Spieler HAT Dörfer:
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
                // Hauptgebäude
                if ($_GET["screen"] == "main")
                {
                    include("include/buildings/main.inc.php");
                }
                // Kaserne
                if ($_GET["screen"] == "barracks")
                {
                    include("include/buildings/barracks.inc.php");
                }
            }
            ?>
        </div>

        <div id="village">
            <div id="topbar">
                <table style="width: calc(100% - 472px)"><tr><td>
                    <?php
                    $res = mysqli_query($db, $usersVillages);
                    $village = mysqli_fetch_assoc($res);
                    echo $village["name"] . " (" . $village["points"] . " Punkte)";
                    ?>
                </td><td align="right">
                    <div id="resources"><?php echo "<img src='graphic/holz.png' height='20' style='vertical-align: middle;'> " .$village["holz"] . " <img src='graphic/stein.png' height='20' style='vertical-align: middle;'> " . $village["stein"] . " <img src='graphic/eisen.png' height='20' style='vertical-align: middle;'> " . $village["eisen"]; ?></div>
                </td></tr></table>
            </div>
            <div id="overview">
                <?php
                // Weltkarte
                if ($_GET["screen"] == "map") {
                    include("include/menu/map.inc.php");
                }
                else {
                    // Dorfübersicht
                    echo "<a href='?village=" . $villageId . "&screen=main'><img style='margin: 25%; width: 10%; position: absolute;' src='graphic/buildings/main.png'></a>";
                    echo "<a href='?village=" . $villageId . "&screen=barracks'><img style='margin: 50%; width: 10%; position: absolute;' src='graphic/buildings/barracks.png'></a>";
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