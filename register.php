<html>
<head>
	<title>Registrierung</title>
	<link rel="stylesheet" type="text/css" href="index.css" charset="utf-8" />
	<meta charset="utf-8">
	<!-- AGB Popup -->
	<script type="text/javascript">
		function popup (url) {
			fenster = window.open(url, "AGB", "width=400,height=300,resizable=yes");
			fenster.focus();
			return false;
		}
	</script>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>Leviathalis</h1>
		</div>
		<div id="content">
			<?
			// Diese Variablen sind später benötigt um zu prüfen, ob ein Feld rot umrahmt werden soll
			// TRUE = Fehlerhafte Eingabe
			$nameInput = false;
			$pwInput = false;
			$emailInput = false;
			$agbCheckbox = false;
			// Wenn Registrierungsformular abgeschickt
			if (isset($_POST["register"]))
			{
				// Datenbankverbindung aufbauen
				require("db.inc.php");
				// Auslesung der registrierten Nutzer in der Datenbank
				$sql = "SELECT name, email FROM users";
				$db_erg = mysqli_query($db, $sql);
				if ( ! $db_erg )
				{
  					die('Ungültige Abfrage: ' . mysqli_error());
				}

				$isNameAvail = true;
				$isEmailAvail = true;
				$name = $_POST["name"]; 
				$email = $_POST["email"];
				$password = $_POST["password"];
				date_default_timezone_set('Europe/Berlin');
				$date = date('Y-m-d H:i:s');

				// Ist der Name noch frei?
				$sql = "SELECT name FROM users WHERE name = '$name'";
				$treffer = mysqli_query($db, $sql);
				if (mysqli_num_rows($treffer)>0)
				{ 
					$isNameAvail = false;
					echo "<span style=\"color:#FF0000;\"><b>Dieser Name ist bereits vergeben.</b></span><br />";  
				}

				// Ist die E-Mail schon registriert?
				$sql = "SELECT email FROM users WHERE email = '$email'";
				$treffer = mysqli_query($db, $sql);
				if (mysqli_num_rows($treffer)>0)
				{ 
					$isEmailAvail = false;
					echo "<span style=\"color:#FF0000;\"><b>Diese E-Mail ist bereits registriert. Hast du vielleicht dein Passw... verarscht, die Funktion haben wir noch nicht.</b></span><br />";  
				}

				// Name und E-Mail noch verfügbar
				if ($isNameAvail && $isEmailAvail)
				{
					// Wenn alle Felder ausgefüllt sind
					if ((($name || $password || $_POST["passwordConfirm"]) != "")
					// Wenn der Name gültig ist (erlaubte Zeichen, 3-20 Zeichen)
					&& (preg_match('~^[0-9a-zA-ZäöüÄÖÜß_\-\.]{3,20}$~', $name))
					// Wenn die E-Mail gültig ist
					&& (filter_var($email, FILTER_VALIDATE_EMAIL))
					// Wenn das Passwort mehr als 5 Zeichen hat
					&& (strlen($password) > 5)
					// Wenn das Passwort und die Bestätigung des Passworts identisch sind
					&& ($password === $_POST["passwordConfirm"])
					// Wenn die AGB akzeptiert wurde
					&& (isset($_POST["agb"])))
					{ 
						// Passwort wird gehasht
						$passwordHashed = password_hash($_POST["password"], PASSWORD_DEFAULT);
						// Daten in eine Tabelle abspeichern
						$order = "INSERT INTO users
									(name, email, password, creationDate)
									VALUES
									('$name','$email','$passwordHashed','$date')";
						$result = mysqli_query($db, $order);
						// Wenn die Verbindung erfolgreich war
						if($result)
						{
							session_start();
							$_SESSION["name"] = $name;
							$_SESSION["password"] = $password;
							header ( 'Location: index.php' );
						}
						// Wenn nicht
						else
						{
							// Fehlermeldung über fehlgeschlagende Verbindung
							echo "<span style='color:#FF0000;'><b>Die Anmeldung schlug fehl. Ein Problem mit der Datenbank liegt vor. Bitte kontaktiere den Support.</b></span><br />";
						}
					}
					// Fehlermeldungen für ungültige Eingaben im Formular
					else
					{
						if ($name == "")
						{
							$nameInput = true;
						}
						if ($email == "")
						{
							$emailInput = true;
						}
						if ($password == "" || $_POST["passwordConfirm"] == "")
						{
							$pwInput = true;
						}
						if (!isset($_POST["agb"]))
						{
							$agbCheckbox = true;
						}

						if (($name || $email || $password || $_POST["passwordConfirm"]) == "")
						{
							echo "<span style=\"color:#FF0000;\"><b>Du musst alle Felder ausfüllen.</b></span><br />";
						}
						else
						{	// Wenn der Name ungültig ist
							if (!preg_match('~^[0-9a-zA-ZäöüÄÖÜß_\-\.]{3,20}$~', $name))
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
									echo "<span style=\"color:#FF0000;\"><b>Namen dürfen nur deutsche Buchstaben, Zahlen, Punkte, Unter- und Bindestriche enthalten.</b></span><br />";
								}
								
								$name = "";
								$nameInput = true;
							}

							// Wenn die E-Mail ungültig ist
							if (filter_var($email, FILTER_VALIDATE_EMAIL) == false)
							{
								echo "<span style=\"color:#FF0000;\"><b>Die E-Mail Adresse ist nicht gültig.</b></span><br />";
								$email = "";
								$emailInput = true;
							}
							
							// Wenn das Passwort nicht lang genug ist
							if (strlen($password) < 6)
							{
								echo "<span style=\"color:#FF0000;\"><b>Dein Passwort muss mindestens 6 Zeichen lang sein.</b></span><br />";
								$password = "";
								$pwInput = true;
							}
							else
							{
								// Wenn die Passwörter identisch sind
								if ($password != $_POST["passwordConfirm"])
								{
									echo "<span style=\"color:#FF0000;\"><b>Die Passwörter sind nicht identisch.</b></span><br />";
									$password = "";
									$pwInput = true;
								}
							}
							// Wenn die AGB nicht akzeptiert wurden
							if (!isset($_POST["agb"]))
							{
								echo "<span style=\"color:#FF0000;\"><b>Du musst die Allgemeinen Geschäftsbedingungen akzeptieren.</b></span><br />";
								$agbCheckbox = true;
							}
						}
					}
				}
			}
			?>
			<!-- Registrierungsformular -->
			<form method="post" action="register.php">
				<table>
					<tr>
						<td>Name</td>
						<td><input type="text" name="name" size="20" <? if(isset($_POST["register"])) { echo "value='$name'"; if($nameInput) { echo "class='formError'"; } } ?> /></td>
					</tr>
					<tr>
						<td>E-Mail</td>
						 <td><input type="email" name="email" size="20" <? if(isset($_POST["register"])) { echo "value='$email'"; if($emailInput) { echo "class='formError'"; } } ?> ></td>
					</tr>
					<tr>
						<td>Passwort</td>
						<td><input type="password" name="password" size="20" <? if(isset($_POST["register"])) { echo "value='$password'"; if($pwInput) { echo "class='formError'"; } } ?> ></td>
					</tr>
					<tr>
						<td>Passwort bestätigen</td>
					 	<td><input type="password" name="passwordConfirm" size="20" <? if(isset($_POST["register"])) { echo "value='$password'"; if($pwInput) { echo "class='formError'"; } } ?> ></td>
					</tr>
					<tr>
						<td><label><input type="checkbox" name="agb" <? if($agbCheckbox) { echo "class='formError'"; } ?> > Ich habe die <a href="agb.html" target="_blank" onclick="return popup(this.href);">AGB</a> gelesen und akzeptiere diese.</label></td>
					</tr>
					<tr>
					  <td></td>
					  <td align="right"><input type="submit" name="register" value="Registrieren"></td>
					</tr>
				</table>
			</form>
		</div>
		<hr />
		<!-- Footer -->
		<div id="footer">
			Copyright &copy; 2014 Marcel Gregoriadis
		</div>
	</div>
</body>
</html>