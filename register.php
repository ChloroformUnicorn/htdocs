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

					$isNameAvail = true;
					$isEmailAvail = true;

					// Jeder Datensatz wird darauf geprüft, ob er den selben NAMEN oder die selbe EMAIL hat, wie der der sich gerade versucht anzumelden
					while ($dsatz = mysqli_fetch_array($db_erg, MYSQL_ASSOC))
					{
						// Ist der Name schon vergeben?
						if ($_POST["name"] == $dsatz['name'])
						{
							$isNameAvail = false;
							echo "<span style=\"color:#FF0000;\"><b>Dieser Name ist bereits vergeben.</b></span><br />";  
						}

						// Ist die E-Mail Adresse bereits registriert?
						if ($_POST["email"] == $dsatz['email'])
						{
							$isEmailAvail = false;
							echo "<span style=\"color:#FF0000;\"><b>Diese E-Mail ist bereits registriert.</b></span><br />";  
						}
					}

					// Name und E-Mail noch verfügbar
					if ($isNameAvail && $isEmailAvail)
					{
							$name = $_POST["name"]; 
						// Bedingungen
						// Wenn alle Felder ausgefüllt sind
						if ((($_POST["name"] || $_POST["password"] || $_POST["passwordConfirm"]) != "")
						// Wenn der Name gültig ist (erlaubte Zeichen, 3-20 Zeichen)
						&& (preg_match('~^[0-9a-zA-ZäöüÄÖÜß_\-\.]{3,20}$~', $_POST["name"]))
						// Wenn die E-Mail gültig ist
						&& (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
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
							if (($_POST["name"] || $_POST["email"] || $_POST["password"] || $_POST["passwordConfirm"]) == "")
							{
								echo "<span style=\"color:#FF0000;\"><b>Du musst alle Felder ausf&uuml;llen.</b></span><br />";
							}
							else
							{	// Wenn der Name ungültig ist
								if (!preg_match('~^[0-9a-zA-ZäöüÄÖÜß_\-\.]{3,20}$~', '$_POST["name"]'))
								{
									// Wenn der Name zu kurz ist
									if (strlen($name) < 3)
									{
										echo "<span style=\"color:#FF0000;\"><b>Dein Name muss mindestens 3 Zeichen lang sein.</b></span><br />";
									}
									// Wenn der Name zu lang ist
									else if (strlen($name) > 20)
									{
										echo "<span style=\"color:#FF0000;\"><b>Dein Name darf maximal 20 Zeichen lang sein.</b></span><br />";
									}
									else
									{
										echo "<span style=\"color:#FF0000;\"><b>Namen d&uuml;rfen nur deutsche Buchstaben, Zahlen, Punkte, Unter- und Bindestriche enthalten.</b></span><br />";
									}
								}

								// Wenn die E-Mail ungültig ist
								if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false)
								{
									echo "<span style=\"color:#FF0000;\"><b>Die E-Mail Adresse ist nicht g&uuml;ltig.</b></span><br />";  
								}
								
								// Wenn das Passwort nicht lang genug ist
								if (strlen($_POST["password"]) < 6)
								{
									echo "<span style=\"color:#FF0000;\"><b>Dein Passwort muss mindestens 6 Zeichen lang sein.</b></span><br />";  
								}
								else
								{
									// Wenn die Passwörter identisch sind
									if ($_POST["password"] != $_POST["passwordConfirm"])
									{
										echo "<span style=\"color:#FF0000;\"><b>Die Passw&ouml;rter sind nicht identisch.</b></span><br />";  
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
				  <td>Passwort best&auml;tigen</td>
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