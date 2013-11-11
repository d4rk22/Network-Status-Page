<?php
	Ini_Set( 'display_errors', true );
	include '../../init.php';
	include 'functions.php';

	$plexSessionXML = simplexml_load_file('http://'.$plex_server_ip.':'.$plex_port.'/status/sessions');
	$plexcheckfile1 = ROOT_DIR . '/assets/caches/plexcheckfile1.txt';
	$plexcheckfile2 = ROOT_DIR . '/assets/caches/plexcheckfile2.txt';
	$plexcheckfile1_md5 = md5_file($plexcheckfile1);
	$plexcheckfile2_md5 = md5_file($plexcheckfile2);
	$viewers = 0;

	// See if Plex Media Server is online and how many people are watching.
	if (!$plexSessionXML):
		// If Plex Media Server is offline.
		$plexStatus = 'offline';
	else:
		// If Plex Media Server is online.
		$plexStatus = 'online';
		// Count how many people are watching.
		if (count($plexSessionXML->Video) > 0) {
			$viewers = count($plexSessionXML->Video);
		}
	endif;

	// Build an array to hold the values
	$array = [
		'status' => $plexStatus,
		'viewers' => $viewers,
	];

	// Write the data out to the first Plex check file
	file_put_contents($plexcheckfile1, $array, LOCK_EX);
	
	// Check to see if it's the same as the second Plex check file
	if ($plexcheckfile1_md5 === $plexcheckfile2_md5) {
		// if they are the same do nothing
	} else {
		// If they are different, update plexcheckfile2
		file_put_contents($plexcheckfile2, $array, LOCK_EX);
	}
?>