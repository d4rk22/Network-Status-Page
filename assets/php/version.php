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
		<script>
		$('.carousel').carousel({
  			interval: 2000
		})
		</script>
<?php
	Ini_Set( 'display_errors', true );
	//include("functions.php");
	//include("lib/forecast.io.php");
	//include ('lib/TransmissionRPC.class.php');

	//$plexNewestXML = simplexml_load_file('http://10.0.1.3:32400/library/sections/7/newest');
	//$mediaKey = $plexNewestXML->Video[0]['key'];
	//$mediaXML = simplexml_load_file('http://10.0.1.3:32400'.$mediaKey);

	//echo $mediaKey;
	//var_dump($mediaXML);

	//if (count($plexNewestXML->Video) > 0) {
	//	$nowplaying = true;
	//}
	//$number = count($plexNewestXML->Video);

	//echo $number;

	//echo $nowplaying;

	//makeRecenlyReleased();

	echo phpinfo();
?>

