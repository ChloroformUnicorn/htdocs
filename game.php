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
            <img src="graphic/sidebar/overview.png">
        </div>
        <div id="overview">
            <?php
            session_start();
            $userId = $_SESSION["id"];
            // Datenbankverbindung aufbauen
            include("db.inc.php");
            $sql = "SELECT * FROM villages WHERE user = '$userId'";
            $result = mysqli_query($db, $sql);
            if ( ! $result )
            {
                die('Ungültige Abfrage: ' . mysqli_error());
            }
            $row = mysqli_fetch_object($result);
            // Logout wenn die Session abgelaufen ist
            if ($_SESSION["id"]=="")
            {
                header("Location: logout.php");
            }
            // Kein Dorf gefunden?
            else if (!$row)
            {
                echo "Du hast ja noch gar keine Dörfer :O";
                $row = mysqli_fetch_object($result);
                $villageName = $row->name . "s Dorf";
                // Daten in eine Tabelle abspeichern
                $sql = "INSERT INTO villages
                            (user, name)
                            VALUES
                            ('$userId','$villageName')";
            }
            // Spieler HAT Dörfer!
            else
            {
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
            }

            ?>
        </div>

        <div id="village">
            <div id="village_topbar">
                <?php
                echo $row->name . " (" . $row->points . " Punkte)";
                ?>
            </div>
            <div id="village_overview">
                <img style="display:table-cell; width:100%;" src="graphic/village.jpg">
            </div>
            <div id="village_footer">
                Copyright Microsoft Corporation bitches
            </div>
        </div>
    </div>
</div>

</body>
</html>