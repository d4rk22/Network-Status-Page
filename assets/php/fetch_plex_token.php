<!DOCTYPE html>
<html lang="en">
<link href="assets/fonts/stylesheet.css" rel="stylesheet">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-wip/css/bootstrap.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.css" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 20px;
				text-align: center;
			}
			.center {
				margin-left:auto;
				margin-right:auto;
			}
			.exoextralight {
				font-family:"exoextralight";
			}
			.exolight {
				font-family:"exolight";
			}
		</style>
		<link rel="shortcut icon" href="assets/ico/favicon.ico">
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-wip/js/bootstrap.min.js"></script>
<?php
	Ini_Set( 'display_errors', true );
	include("../functions.php");

	$network = getNetwork();
	$sign_in_XML = '/Users/zeus/Sites/d4rk.co/assets/misc/sign_in.xml';

	if (file_exists($sign_in_XML) && (filemtime($sign_in_XML) > (time() - 60 * 60 *24))) {
		// XML is less than 1 day old.
		// Use the existing Plex XML.
		$token = file_get_contents($sign_in_XML);
		echo 'XML is less than 1 day old.';
	} else {
		$myPlex = shell_exec('curl -H "Content-Length: 0" -H "X-Plex-Client-Identifier: my-app" -u"ryan@d4rk.co":"Insight22" -X POST https://my.plexapp.com/users/sign_in.xml');
		//$currentXML = file_get_contents($myPlex);
		$output = simplexml_load_string($myPlex);
		$token = $output['authenticationToken'];
		file_put_contents($sign_in_XML, $token, LOCK_EX);
		echo 'XML is more than 1 day old.';
	}

	echo 'The token is: '.$token;
?>

