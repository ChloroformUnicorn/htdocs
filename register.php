<html>
<head>
	<title>Registrierung</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>Das beste Browsergame der Welt</h1>
		</div>
		<div id="content">
			<?
			if (isset($_POST["submit"])) 
			{
				if ((($_POST["name"] || $_POST["password"] || $_POST["passwordConfirm"]) != "")
					&& (strlen($_POST["name"]) > 2)
					&& (strlen($_POST["password"]) > 5)
					&& ($_POST["password"] === $_POST["passwordConfirm"]))
				{
					mysql_connect("localhost","root","123"); //database connection
					mysql_select_db("users");
					 
					$name = $_POST["name"]; 
					$password = $_POST["password"];
					 
					//inserting data order
					$order = "INSERT INTO data
								(name, password)
								VALUES
								('$name',
								'$password')";
					 
					//declare in the order variable
					$result = mysql_query($order);  //order executes
					if($result)
					{
						echo("<br>Erfolgreich angemeldet!");
						//header ( 'Location: index.php' );
					}
					else
					{
						echo("<br>Die Anmeldung schlug fehl.");
					}
				}
				else
				{
					if (($_POST["name"] || $_POST["password"] || $_POST["passwordConfirm"]) == "")
					{
						echo "<span style=\"color:#FF0000;\">Du musst alle Felder ausfüllen.</span><br />";  
					}
					else
					{
						if (strlen($_POST["name"]) <= 2)
						{
							echo "<span style=\"color:#FF0000;\">Dein Nickname muss mindestens 3 Zeichen lang sein.</span><br />";  
						}
						
						if (strlen($_POST["password"]) <= 5)
						{
							echo "<span style=\"color:#FF0000;\">Dein Passwort muss mindestens 6 Zeichen lang sein.</span><br />";  
						}
						else
						{
							if ($_POST["password"] != $_POST["passwordConfirm"])
							{
								echo "<span style=\"color:#FF0000;\">Die Passwörter sind nicht identisch.</span><br />";  
							}
						}
					}
				}
				
			}
			?>
			<table>
				<form method="post" action="register.php">
				<tr>
				  <td>Name</td>
				  <td><input type="text" name="name" size="20">
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
				  name="submit" value="Registrieren"></td>
				</tr>
			</table>
		</div>
		<div id="footer">
			Copyright &copy; 2014 Marcel Gregoriadis
		</div>
	</div>
</body>
</html>
