<html>
<head>
	<title>Registrierung</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>Leviathalis</h1>
		</div>
		<div id="content">

			<?
				// Wenn Registrierungsformular abgeschickt
				if (isset($_POST["register"])) 
				{
					// Datenbankverbindung aufbauen
					include("db.inc.php");

					// Auslesung der registrierten Nutzer in der Datenbank
					$sql = "SELECT name FROM users";
					$db_erg = mysqli_query($db, $sql);
					if ( ! $db_erg )
					{
	  					die('Ungültige Abfrage: ' . mysqli_error());
					}

					$nameAvail = true;

					// Jeder Datensatz wird darauf geprüft, ob er den selben NAMEN hat, wie der der sich gerade versucht anzumelden
					while ($dsatz = mysqli_fetch_array($db_erg, MYSQL_ASSOC))
					{
						// Name schon vergeben
						if ($_POST["name"] == $dsatz['name'])
						{
							$nameAvail = false;
							echo "<span style=\"color:#FF0000;\"><b>Dieser Name ist bereits vergeben.</b></span><br />";  
						}
					}

					// Name noch verfügbar
					if ($nameAvail == true)
					{
						// Bedingungen
						// Wenn alle Felder ausgefüllt sind
						if ((($_POST["name"] || $_POST["password"] || $_POST["passwordConfirm"]) != "")
						// Wenn der Name mehr als 2 Zeichen hat
						&& (strlen($_POST["name"]) > 2)
						// Wenn der Name weniger als 20 Zeichen hat
						&& (strlen($_POST["name"]) < 21)
						// Wenn die E-Mail mehr als 5 Zeichen hat (a@b.cd)
						&& (strlen($_POST["email"]) > 5)
						// Wenn das Passwort mehr als 5 Zeichen hat
						&& (strlen($_POST["password"]) > 5)
						// Wenn das Passwort und die Bestätigung des Passworts identisch sind
						&& ($_POST["password"] === $_POST["passwordConfirm"]))
						{
							
							// Einzutragende Werte initialisieren
							$name = $_POST["name"]; 
							$email = $_POST["email"]; 
							$password = $_POST["password"];
							date_default_timezone_set('Europe/Berlin');
							$date = date('Y-m-d H:i:s');
							 
							// Daten in eine Tabelle abspeichern
							$order = "INSERT INTO users
										(name, email, password, creationDate)
										VALUES
										('$name','$email','$password','$date')";
							 
							// War die Verbindung erfolgreich?
							$result = mysqli_query($db, $order);
							
							// Wenn JA
							if($result)
							{
								session_start();
								$_SESSION["name"] = $_POST["name"];
								header ( 'Location: index.php' );
							}

							// Wenn NEIN
							else
							{
								// Fehlermeldung über fehlgeschlagende Verbindung
								echo "<span style=\"color:#FF0000;\"><b>Die Anmeldung schlug fehl. Ein Problem mit der Datenbank liegt vor. Bitte kontaktiere den Support in diesem Fall.</b></span><br />";
							}
						}
						
						// Fehlermeldungen für ungültige Eingaben im Formular
						else
						{
							if (($_POST["name"] || $_POST["password"] || $_POST["passwordConfirm"]) == "")
							{
								echo "<span style=\"color:#FF0000;\"><b>Du musst alle Felder ausfüllen.</b></span><br />";
							}
							else
							{
								if (strlen($_POST["name"]) < 3)
								{
									echo "<span style=\"color:#FF0000;\"><b>Dein Nickname muss mindestens 3 Zeichen lang sein.</b></span><br />";  
								}

								if (strlen($_POST["name"]) > 20)
								{
									echo "<span style=\"color:#FF0000;\"><b>Dein Nickname darf nicht mehr als 20 Zeichen lang sein.</b></span><br />";  
								}
								
								if (strlen($_POST["password"]) < 6)
								{
									echo "<span style=\"color:#FF0000;\"><b>Dein Passwort muss mindestens 6 Zeichen lang sein.</b></span><br />";  
								}
								else
								{
									if ($_POST["password"] != $_POST["passwordConfirm"])
									{
										echo "<span style=\"color:#FF0000;\"><b>Die Passwörter sind nicht identisch.</b></span><br />";  
									}
								}
							}
						}
					}
					
				}
			?>
			<table>
				<!-- Registrierungsformular -->
				<form method="post" action="register.php">
				<tr>
				  <td>Name</td>
				  <td><input type="text" name="name" size="20">
				  </td>
				</tr>
				<tr>
				  <td>E-Mail</td>
				  <td><input type="text" name="email" size="20">
				  </td>
				</tr>
				<tr>
				  <td>Passwort</td>
				  <td><input type="password" name="password" size="20">
				  </td>
				</tr>
				<tr>
				  <td>Passwort bestätigen</td>
				  <td><input type="password" name="passwordConfirm" size="20">
				  </td>
				</tr>
				<tr>
				  <td></td>
				  <td align="right"><input type="submit"
				  name="register" value="Registrieren"></td>
				</tr>
			</table>
		</div>
		
		<!-- Footer -->
		<div id="footer">
			<hr />
			Copyright &copy; 2014 Marcel Gregoriadis
		</div>
	</div>
</body>
</html>