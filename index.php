<html>
<head>
	<title>Leviathalis</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>Leviathalis</h1>
		</div>
		<div id="content">
			<div id="login">
				<h3>Anmelden</h3>
				<?
					// Session aufnehmen
					session_start();
					
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
				<form method="post" action="frontpage.php">
				<table>
					<tr><td width="100" height="50">Name: </td><td><input type="text" name="name" size="20"></td></tr>
					<tr><td width="100" height="50">Passwort: </td><td><input type="password" name="name" size="20"></td></tr>
					<tr>
						<div align="right">
							<td></td><td align="right"><input type="submit" name="submit" value="Login"></td>
						</div>
					</tr>
				</table>
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