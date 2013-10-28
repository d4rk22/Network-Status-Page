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
	include("functions.php");
	include("lib/forecast.io.php");
	include ('lib/TransmissionRPC.class.php');

	//echo $mediaKey;
	//var_dump($mediaXML);

	//if (count($plexNewestXML->Video) > 0) {
	//	$nowplaying = true;
	//}
	//$number = count($plexNewestXML->Video);

	//echo $number;

	//echo $nowplaying;

	//makeRecenlyReleased();

	//echo phpinfo();
	//$sabnzbdXML = simplexml_load_file('http://10.0.1.3:8080/api?mode=qstatus&output=xml&apikey=d8f21cb16e5dd227e8e33909a2c4c081');

//function sabSpeedAdjuster()
//{
	// Check the current ping
	$avgPing = ping();
	// Set how high ping we want to hit before throttling
	$ping_high = 70;
	// Get SABnzbd XML
	$sabnzbdXML = simplexml_load_file('http://10.0.1.3:8080/api?mode=queue&start=START&limit=LIMIT&output=xml&apikey=d8f21cb16e5dd227e8e33909a2c4c081');
	// What is the current speed limit
	$sabSpeedLimitCurrent = $sabnzbdXML->speedlimit;
	// SAB Min Speed Limit
	$sabSpeedLimitMax = 4096;
	$sabSpeedLimitMin = 256;
	// SAB Max Speed Limit
	// Check to see if SAB is downloading
	if (($sabnzbdXML->status) == 'Downloading'):
			// If it is downloading and ping is over X value, slow it down
			if ($avgPing > $ping_high):
				if ($sabSpeedLimitCurrent > $sabSpeedLimitMin):
					// Reduce speed by 256KBps
					echo 'Ping is over '.$ping_high;
					echo '<br>';
					echo 'Slowing down SAB';
					$sabSpeedLimitSet = $sabSpeedLimitCurrent - 256;
					shell_exec('curl "http://10.0.1.3:8080/api?mode=config&name=speedlimit&value='.$sabSpeedLimitSet.'&apikey=d8f21cb16e5dd227e8e33909a2c4c081"');
				else:
					echo 'Ping is over '.$ping_high.' but SAB cannot slow down anymore';
				endif;	
			elseif (($avgPing + 10) < $ping_high):
				if ($sabSpeedLimitCurrent < $sabSpeedLimitMax):
					// Increase speed by 256KBps
					echo 'SAB is downloading but and ping is low enough so increasing download speed.';
					$sabSpeedLimitSet = $sabSpeedLimitCurrent + 256;
					shell_exec('curl "http://10.0.1.3:8080/api?mode=config&name=speedlimit&value='.$sabSpeedLimitSet.'&apikey=d8f21cb16e5dd227e8e33909a2c4c081"');
				else:
					echo 'SAB is downloading. Ping is low enough but we are at global download speed limit.';
				endif;
			else:
				echo 'SAB is downloading. Ping is ok but not low enough to speed up SAB.';
			endif;
		else:
			// do nothing, 
			echo 'SAB is not downloading.';
		endif;
	
//}
	echo '<br>';

	//print_r($sabnzbdXML);

	echo '<br>';
	echo '<br>';
	echo 'Current ping: ';
	echo $avgPing;
	echo '<br>';
	echo 'Current Speed Limit: ';
	echo $sabSpeedLimitCurrent;
	echo '<br>';
	if ($sabSpeedLimitSet) {
		echo 'New Speed Limit: ';
		echo $sabSpeedLimitSet;
	}

?>

