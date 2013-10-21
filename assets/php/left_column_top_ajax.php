<!DOCTYPE html>
<?php
	Ini_Set( 'display_errors', true );
	include("functions.php");

	$plexSessionXML = simplexml_load_file('http://10.0.1.3:32400/status/sessions');
	$clientIP = get_client_ip();
	//$clientIP = '10.0.1.1';
	if($clientIP == '10.0.1.1'):
		// extra if code for only displaying weather when plex is playing:   && count($plexSessionXML->Video) > 0
		//echo '<h4 class="exoextralight">Forecast</h4>';
		//echo '<iframe id="forecast_embed" type="text/html" frameborder="0" height="245" width="100%" src="http://forecast.io/embed/#lat=40.7838&lon=-96.622773&name=Lincoln, NE"> </iframe>';
		makeWeatherSidebar();
	else:
		echo '<ul class="nav nav-pills nav-stacked">';
		echo '<!-- Online profiles -->';
		echo '<li class="exoextralight">Online profiles</li>';
		echo '<li><a href="http://d4rk.co" target="_blank"><i class="icon-fixed-width icon-globe"/></i> Home</a></li>';
		echo '<li><a href="http://ryanchristensen.net" target="_blank"><i class="icon-fixed-width icon-cloud"></i> Blog</a></li>';
		echo '<li><a href="http://twitter.com/ryanchristensen" target="_blank"><i class="icon-fixed-width icon-twitter"></i> Twitter</a></li>';
		echo '<li><a href="#contactModal" data-toggle="modal"><i class="icon-fixed-width icon-envelope"></i> Contact</a></li>';
		echo '</ul>';
	endif;
?>
