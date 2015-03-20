<?php
session_start();
// Logout wenn die Session abgelaufen ist
if ($_SESSION["id"]=="")
{
    header("Location: logout.php");
}
// Datenbankverbindung aufbauen
require("db.inc.php");
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
        var woodSource = <?php echo $village["res1"] ?>;
        var stoneSource = <?php echo $village["res2"] ?>;
        var ironSource = <?php echo $village["res3"] ?>;
        var wood = <?php echo $village["holz"] ?>;
        var stone = <?php echo $village["stein"] ?>;
        var iron = <?php echo $village["eisen"] ?>;
        var store = <?php
                    require "include/config.inc.php";
                    capacity($village["store"]);
                    echo $cap;
                    ?>;

        setInterval(function() { 
            // Ressourcen-Anzeige updaten
            if ((woodSource * 20 + wood) > store) {
                wood = store;
            } else {
                wood += woodSource * 20;
            }
            if ((stoneSource * 20 + stone) > store) {
                stone = store;
            } else {
                stone += stoneSource * 20;
            }
            if ((ironSource * 20 + iron) > store) {
                iron = store;
            } else {
                iron += ironSource * 20;
            }
            document.getElementById("wood").innerHTML = wood;
            document.getElementById("stone").innerHTML = stone;
            document.getElementById("iron").innerHTML = iron;
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
            // Bauschleife updaten
            $.ajax({ 
              url:'include/buildings/include/recruitQueue.inc.php?village=<?php echo $villageId; ?>', 
              type:"POST", 
              async:true, 
              data:{}, 
              success:function(data) { 
                $("#recruitQueue").html(data);
              } 
            });
        },1000);

        $(document).ready(function() {
            // Transparenz-Efekt der Sidebar-Icons
            $("#sidebar img").mouseenter(function() {
                $(this).fadeTo(0, 0.75);
            });
            $("#sidebar img").mouseleave(function() {
                $(this).fadeTo(0, 1);
            });
        });
    </script>
</head>
<body>
<div class="outterWrapper">
    <div class="innerWrapper">
        <!-- Sidebar -->
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
                require("include/create_village.inc.php");
            }
            // Spieler HAT Dörfer:
            else
            {
                // Übersichten
                if ($_GET["screen"] == "overview")
                {
                    require "include/menu/overview.inc.php";
                }
                // Berichte
                else if ($_GET["screen"] == "reports")
                {
                    require "include/menu/reports.inc.php";
                }
                // Hauptgebäude
                if ($_GET["screen"] == "main")
                {
                    require "include/buildings/main.inc.php";
                }
                // Kaserne
                if ($_GET["screen"] == "barracks")
                {
                    require "include/buildings/barracks.inc.php";
                }
                // Speicher
                if ($_GET["screen"] == "store")
                {
                    require "include/buildings/store.inc.php";
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
                    <img src='graphic/holz.png' height='20' style='vertical-align: middle;'> <span id="wood"><?php echo $village["holz"]; ?></span>
                    <img src='graphic/stein.png' height='20' style='vertical-align: middle;'> <span id="stone"><?php echo $village["stein"]; ?></span>
                    <img src='graphic/eisen.png' height='20' style='vertical-align: middle;'> <span id="iron"><?php echo $village["eisen"]; ?></span>
                </td></tr></table>
            </div>
            <div id="overview">
                <?php
                // Weltkarte
                if ($_GET["screen"] == "map") {
                    require("include/menu/map.inc.php");
                }
                else {
                    // Dorfübersicht
                    echo "<a href='?village=$villageId&screen=main'><img style='margin: 25%; width: 10%; position: absolute;' src='graphic/buildings/main.png'></a>";
                    echo "<a href='?village=$villageId&screen=barracks'><img style='margin: 50%; width: 10%; position: absolute;' src='graphic/buildings/barracks.png'></a>";
                    echo "<a href='?village=$villageId&screen=store'><img style='margin-left: 25%; margin-top: 50%; width: 10%; position: absolute;' src='graphic/buildings/store.png'></a>";
                }
                ?>
            </div>
            <div id="footer">
                Copyright by Marcel Gregoriadis & Hai Dang Nguyen
            </div>
        </div>
    </div>
</div>
</body>
</html>