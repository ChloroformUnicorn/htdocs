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
            Test
        </div>
        <div id="overview">
            <?php
            session_start();
            $userId = $_SESSION["id"];
            // Datenbankverbindung aufbauen
            include("db.inc.php");
            mysqli_set_charset($db, 'utf8');
            $sql = "SELECT * FROM villages WHERE user = '$userId'";
            $db_erg = mysqli_query($db, $sql);
            if ( ! $db_erg )
            {
                die('Ungültige Abfrage: ' . mysqli_error());
            }
            $row = mysqli_fetch_object($db_erg);

            if ($_SESSION["id"]=="")
            {
                header("Location: logout.php");
            }
            else if (!$row)
            {
                echo "Du hast ja noch gar keine Dörfer :O";
                $sql = "SELECT id, name FROM users WHERE id = '$userId'";
                $db_erg = mysqli_query($db, $sql);
                if ( ! $db_erg )
                {
                    die('Ungültige Abfrage: ' . mysqli_error());
                }
                $row = mysqli_fetch_object($db_erg);
                $villageName = $row->name . "s Dorf";
                // Daten in eine Tabelle abspeichern
                $order = "INSERT INTO villages
                            (user, name)
                            VALUES
                            ('$userId','$villageName')";
                 
                // War die Verbindung erfolgreich?
                $result = mysqli_query($db, $order);
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