<?php
	Ini_Set( 'display_errors', true );
	include '../../init.php';
	include 'functions.php';
	
	$network = getNetwork();
	$plexSessionXML = simplexml_load_file($network.':'.$plex_port.'/status/sessions');

	$plexSessionID = $_GET['id'];

	$duration = $plexSessionXML->Video[$plexSessionID]['duration'];
	$viewOffset = $plexSessionXML->Video[$plexSessionID]['viewOffset'];
	$progress = sprintf('%.0f',($viewOffset / $duration) * 100);
	
	return $progress;
?>