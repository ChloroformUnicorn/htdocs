<?
session_start();
// Logout wenn die Session abgelaufen ist
if ($_SESSION["id"]=="")
{
    header("Location: logout.php");
}
require "db.inc.php";
$userId = $_SESSION["id"];
$villageId = $_GET["village"];
// Datensatz des Users
$getUser = mysqli_query($db, "SELECT * FROM users WHERE id = '$userId'");
$user = mysqli_fetch_assoc($getUser);
// Datensatz der Dörfer des eingeloggten User
$getVillage = mysqli_query($db, "SELECT * FROM villages WHERE id = '$villageId'");
$village = mysqli_fetch_assoc($getVillage);
require "include/config.inc.php";
?>
<html>
<head>
    <title>Spiel</title>
    <link rel="stylesheet" type="text/css" href="game.css" charset="utf-8" />
    <meta charset="utf-8">
    <script src="jquery.min.js"></script>
    <script type="text/javascript">
        var woodSource = <? echo $village["res1"] ?>;
        var stoneSource = <? echo $village["res2"] ?>;
        var ironSource = <? echo $village["res3"] ?>;
        var wood = <? echo $village["holz"] ?>;
        var stone = <? echo $village["stein"] ?>;
        var iron = <? echo $village["eisen"] ?>;
        var store = <? capacity($village["store"]); echo $cap; ?>;

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
              url:'include/buildings/include/buildQueue.inc.php?village=<? echo $villageId; ?>', 
              type:"POST", 
              async:true, 
              data:{}, 
              success:function(data) { 
                $("#buildQueue").html(data);
              }
            });
            // Bauschleife updaten
            $.ajax({ 
              url:'include/buildings/include/recruitQueue.inc.php?village=<? echo $villageId; ?>', 
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
            $("#sidebar img").hover(function() {
                $(this).fadeTo(0, 0.75);
            }, function() {
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
            <a href="game.php?village=<? echo $villageId; ?>&screen=overview"><img src="graphic/sidebar/overview.png"></a><br/>
            <a href="game.php?village=<? echo $villageId; ?>&screen=reports"><img src="graphic/sidebar/reports.png"></a><br/>
            <a href="game.php?village=<? echo $villageId; ?>&screen=map"><img src="graphic/sidebar/map.png"></a><br/>
            <a href="game.php?village=<? echo $villageId; ?>&screen=ranking"><img src="graphic/sidebar/ranking.png"></a><br/>
            <a href="logout.php"><img src="graphic/sidebar/logout.png"></a><br/>
        </div>
        <div id="menu">
            <?
            // Kein Dorf gefunden?
            if (!$village)
            {
                echo "Du hast ja noch gar kein Dorf :O";
                require "include/create_village.inc.php";
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
                // Karte
                if ($_GET["screen"] == "map")
                {
                    require "include/menu/map2.inc.php";
                }
                // Rangliste
                if ($_GET["screen"] == "ranking")
                {
                    require "include/menu/ranking.inc.php";
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
                // Bauernhof
                if ($_GET["screen"] == "farm")
                {
                    require "include/buildings/farm.inc.php";
                }
            }
            ?>
        </div>
        <div id="village">
            <div id="topbar">
                <?
                echo "<table style='width: calc(100% - 472px)'><tr><td>";
                if (mysqli_num_rows(mysqli_query($db, "SELECT * FROM villages WHERE user = '$userId'")) > 1) {
                    // Vorheriges Dorf finden
                    $getPrevious = mysqli_query($db, "SELECT id FROM villages WHERE user = '$userId' AND id < '$villageId' ORDER BY id DESC");
                    if (mysqli_num_rows($getPrevious) < 1) {
                        $getPrevious = mysqli_query($db, "SELECT id FROM villages WHERE user = '$userId' AND id > '$villageId' ORDER BY id DESC");
                    }
                    $previous = mysqli_fetch_assoc($getPrevious);
                    $previous = $previous["id"];
                    // Nachfolgendes Dorf finden
                    $getNext = mysqli_query($db, "SELECT id FROM villages WHERE user = '$userId' AND id > '$villageId'");
                    if (mysqli_num_rows($getNext) < 1) {
                        $getNext = mysqli_query($db, "SELECT id FROM villages WHERE user = '$userId' AND id < '$villageId'");
                    }
                    $next = mysqli_fetch_assoc($getNext);
                    $next = $next["id"];
                }
                echo $village["name"]." (".$village["points"]." Punkte) <a href='?village=$previous&screen=".$_GET["screen"]."'><img src='graphic/arrow-left.png'></a> <a href='?village=$next&screen=".$_GET["screen"]."'><img src='graphic/arrow-right.png'></a>
                                    </td><td align='right'>
                                        <img src='graphic/holz.png' class='topbar-icons'> <span id='wood'>".$village["holz"]."</span>
                                        <img src='graphic/stein.png' class='topbar-icons'> <span id='stone'>".$village["stein"]."</span>
                                        <img src='graphic/eisen.png' class='topbar-icons'> <span id='iron'>".$village["eisen"]."</span> |
                                        <img src='graphic/store.png' class='topbar-icons'>"; capacity($village["store"]); echo $cap."
                                        <img src='graphic/farm.png' class='topbar-icons'>"; capacity($village["farm"]); echo $village["phalanx"]."/".$farmCap."
                                    </td></tr></table>
                                </div>
                    <div id='overview'>";
                // Weltkarte
                if ($_GET["screen"] == "map") {
                    require "include/menu/map.inc.php";
                }
                else {
                    // Hauptgebäude
                    echo "<div class='buildingInfo' style='margin-top: 20%; margin-left: 22%;'>".$village["main"]."</div>";
                    echo "<a href='?village=$villageId&screen=main'><img style='margin: 25%; width: 10%; position: absolute;' src='graphic/buildings/main.png'></a>";
                    // Kaserne
                    echo "<div class='buildingInfo' style='margin-top: 45%; margin-left: 46%;'>".$village["barracks"]."</div>";
                    echo "<a href='?village=$villageId&screen=barracks'><img style='margin: 50%; width: 10%; position: absolute;' src='graphic/buildings/barracks.png'></a>";
                    // Speicher
                    echo "<div class='buildingInfo' style='margin-top: 45%; margin-left: 22%;'>".$village["store"]."</div>";
                    echo "<a href='?village=$villageId&screen=store'><img style='margin-left: 25%; margin-top: 50%; width: 10%; position: absolute;' src='graphic/buildings/store.png'></a>";
                    // Bauernhof
                    echo "<div class='buildingInfo' style='margin-top: 15%; margin-left: 47%;'>".$village["farm"]."</div>";
                    echo "<a href='?village=$villageId&screen=farm'><img style='margin-left: 50%; margin-top: 20%; width: 10%; position: absolute;' src='graphic/buildings/farm.png'></a>";
                    // Holzfäller
                    echo "<div class='buildingInfo' style='margin-top: 15%; margin-left: 47%;'>".$village["farm"]."</div>";
                    echo "<a href='?village=$villageId&screen=farm'><img style='margin-left: 50%; margin-top: 20%; width: 10%; position: absolute;' src='graphic/buildings/farm.png'></a>";
                    // Lehmgrube
                    echo "<div class='buildingInfo' style='margin-top: 15%; margin-left: 47%;'>".$village["farm"]."</div>";
                    echo "<a href='?village=$villageId&screen=farm'><img style='margin-left: 50%; margin-top: 20%; width: 10%; position: absolute;' src='graphic/buildings/farm.png'></a>";
                    // Eisenmine
                    echo "<div class='buildingInfo' style='margin-top: 15%; margin-left: 47%;'>".$village["farm"]."</div>";
                    echo "<a href='?village=$villageId&screen=farm'><img style='margin-left: 50%; margin-top: 20%; width: 10%; position: absolute;' src='graphic/buildings/farm.png'></a>";

                }
                // Truppen Inventar
                echo "</div>
                    <div id='troops'>
                        <img src='graphic/troops/phalanx.png' width='16'> ".getAvailableTroops("phalanx")." Phalanx 
                        <img src='graphic/troops/swordsman.png' width='16'> ".getAvailableTroops("swordsman")." Schwertkämpfer
                        <img src='graphic/troops/archer.png' width='16'> ".getAvailableTroops("archer")." Bogenschütze
                    </div>";
                ?>
            </div>
        </div>
    </div>
</body>
</html>