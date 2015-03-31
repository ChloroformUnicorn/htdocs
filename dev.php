<?
function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}
$ua=getBrowser();
?>
<html>
<head>
	<title>Server & Client Daten (Vergleich)</title>
	<link rel="stylesheet" type="text/css" href="index.css" />
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
		<div id="content" align=center>
			<h3>Daten zu diesem Server und verwendetem Client:</h3>
			<table border=1>
				<tr>
					<td><b>PHP Version:</b> </td><td><? echo phpversion(); ?></td>
				</tr>
				<tr>
					<td><b>Apache Version:</b> </td><td><? echo apache_get_version(); ?></td>
				</tr>
				<tr>
					<td><b>MySQL Version (Server):</b> </td><td><? require("db.inc.php"); echo mysqli_get_server_info($db); ?></td>
				</tr>
				<tr>
					<td><b>MySQL Version (Client):</b> </td><td><? echo mysqli_get_client_info(); ?></td>
				</tr>
                <tr>
                    <td><b>Webbrowser:</b> </td><td><? echo $ua["name"] . " " . $ua["version"] . " auf " . $ua["platform"]; ?></td>
                </tr>
			</table>
			<h3>Server & Client Daten mit denen programmiert und getestet wurde</h3>
			<table border=1>
				<tr>
					<td><b>PHP Version:</b> </td><td>5.5.15</td>
				</tr>
				<tr>
					<td><b>Apache Version:</b> </td><td>Apache/2.4.10 (Unix) OpenSSL/1.0.1i PHP/5.5.15 mod_perl/2.0.8-dev Perl/v5.16.3</td>
				</tr>
				<tr>
					<td><b>MySQL Version (Server):</b> </td><td>5.6.20</td>
				</tr>
				<tr>
					<td><b>MySQL Version (Client):</b> </td><td>mysqlnd 5.0.11-dev - 20120503 - $Id: bf9ad53b11c9a57efdb1057292d73b928b8c5c77 $</td>
				</tr>
				<tr>
					<td><b>Webbrowser:</b> </td><td>Apple Safari 8.0 auf Mac</td>
				</tr>
			</table>
		</div>
		<hr />
		<!-- Footer für Copyrights o.ä. -->
		<div id="footer">
			Copyright &copy; 2014 Marcel Gregoriadis
			<div align="right">
				<a href="dev.php">Dev</a>
			</div>
		</div>
	</div>
</body>
</html>