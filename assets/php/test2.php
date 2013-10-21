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
	include ('../lib/Transmissi./onRPC.class.php');

	$rpc = new TransmissionRPC();

	$rpc->username = 'admin';
  	$rpc->password = 'Insight22';

  	$stats = $rpc->request( "session-stats", array() );

	var_dump($stats);

	var_dump($rpc);

	echo 'this sucks';
?>