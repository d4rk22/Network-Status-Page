<?php
	Ini_Set( 'display_errors', true );
	include '../../init.php';
	include 'functions.php';

	// This is separate from the now_playing div because the now_playing div
	// is a special scrollable div and we don't want the title scrolling with it.
	// You will only notice the scrolling feature when there are multiple
	// shows being watched at the same time.
	
	$network = getNetwork();
	$plexSessionXML = simplexml_load_file($network.':'.$plex_port.'/status/sessions');

	// See if Plex Media Server is online and how many people are watching.
	if (!$plexSessionXML):
		// If Plex Media Server is offline.
		$title = 'Recently Viewed';
	else:
		// If Plex Media Server is online.
		if (count($plexSessionXML->Video) == 0):
			$title = 'Recently Released';
		else:
			$title = 'Now Playing';
		endif;
	endif;

	echo '<h1 class="exoextralight">'.$title.'</h1>';
	echo '<hr>';
?>
