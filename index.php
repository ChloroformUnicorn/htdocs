<html>
<head>
	<title>Leviathalis</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8">
</head>
<body>
	<div id="container">
		<div id="topbar">
			Spielinfo - Support - Hilfe
		</div>
		<div id="header">
			<h1>Leviathalis</h1>
		</div>
		<div id="content">
			<div id="login">
				<h3>Anmelden</h3>
				<?php
				session_start();

				if (isset($_POST["login"]))
				{
					// Datenbankverbindung aufbauen
					include("db.inc.php");
					mysqli_set_charset($db, 'utf8');
					// Name und Passwort des Logins in Variablen speichern
					$name = $_POST["name"];
					$pw = $_POST["pw"];
					// Suche in der Datenbank nach diesem User
					$sql = "SELECT name, password, id FROM users WHERE name = '$name'";
					$db_erg = mysqli_query($db, $sql);
					if ( ! $db_erg )
					{
						die('Ungültige Abfrage: ' . mysqli_error());
					}
					$row = mysqli_fetch_object($db_erg);

					// Wenn der Name in der Datenbank gefunden wurde
					if ($row == true)
					{
						// Ist das Passwort korrekt?
						if (password_verify($pw, $row->password))
						{
							$id = $row->id;
							$_SESSION["id"] = $id;
							// Sollen die Daten gespeichert werden (Cookie)?
							if ($_POST["saveData"])
							{
								setcookie("username",$name,time()+(100*24*3600)); 
								setcookie("password",$pw,time()+(100*24*3600));
							}
							header ( 'Location: game.php' );
						}
						else
						{
							echo "<span style=\"color:#FF0000;\"><b>Das Passwort ist nicht korrekt.</b></span><br />";
						}
					}
					else
					{
						$name = "";
						echo "<span style=\"color:#FF0000;\"><b>Account nicht vorhanden.</b></span><br />";
					}
				}

				// Wenn sich der Nutzer soeben registriert hat
				if (isset($_SESSION["name"]))
				{
					// Informiere Nutzer über erfolgreiche Registrierung
					echo "<span style=\"color:#31B404;\"><b>Hallo " . $_SESSION["name"] . "! Du hast dich erfolgreich registriert.</b>";
					// Beende Session, damit die Meldung nicht während der ganzen Internetsitzung auf der Startseite erscheint
					session_destroy();
				}
				?>
				<!-- Login Formular -->
				<div id="formError">
				<form method="post" action="index.php">
					<table>
						<tr><td width="100" height="50">Name: </td><td><input type="text" name="name" size="20"
							<?php
							if (isset($_POST["login"]))
							{
								echo "value='$name'";
							}
							else if (isset($_COOKIE['username']))
							{
								$username = $_COOKIE["username"];
								echo "value='$username'"; 
							}
							?>
							></td></tr>
						<tr><td width="100" height="50">Passwort: </td><td><input type="password" name="pw" size="20"
							<?php
							if(!isset($_POST["login"]) && isset($_COOKIE['password']))
							{
								$password = $_COOKIE["password"];
								echo "value='$password'";
							}
							?>
							></td></tr>
						<tr>
							<td colspan="2"><input type="checkbox" name="saveData"> Login-Daten merken</td>
						</tr>
						<tr>
							<div align="right">
								<td></td><td align="right"><input type="submit" name="login" value="Login"></td>
							</div>
						</tr>
					</table>
				</form></div>
				<a href="register.php">Noch nicht registriert? Erstelle jetzt kostenlos einen Account!</a>
			</div>
			<!-- Inhalt der rechten Seitenhälften -->
			<div id="main">
				<h2>Hallo</h2>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>
			</div>
		</div>
		<!-- Footer für Copyrights o.ä. -->
		<div id="footer">
			<hr />
			Copyright &copy; 2014 Marcel Gregoriadis
		</div>
	</div>
</body>
</html>