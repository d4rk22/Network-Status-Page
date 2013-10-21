<!DOCTYPE html>
<?php
	Ini_Set( 'display_errors', true );
	include("functions.php");

	$plexSessionXML = simplexml_load_file('http://10.0.1.3:32400/status/sessions');
	$plexcheckfile1 = '/Users/zeus/Sites/d4rk.co/assets/misc/plexcheckfile1.txt';
	$plexcheckfile2 = '/Users/zeus/Sites/d4rk.co/assets/misc/plexcheckfile2.txt';
	$plexcheckfile1_md5 = md5_file($plexcheckfile1);
	$plexcheckfile2_md5 = md5_file($plexcheckfile2);
	$nowplaying = false;
	$viewers = 0;

	if (count($plexSessionXML->Video) > 0) {
		$viewers = count($plexSessionXML->Video);
	}
	file_put_contents($plexcheckfile1, $viewers, LOCK_EX);

	
	if ($plexcheckfile1_md5 === $plexcheckfile2_md5) {
		// if they are the same do nothing
	} else {
		// If they are different, update plexcheckfile2
		file_put_contents($plexcheckfile2, $viewers, LOCK_EX);
	}
	
?>