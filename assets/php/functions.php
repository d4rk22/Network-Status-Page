<?php
	Ini_Set( 'display_errors', false);
	include("lib/phpseclib0.3.5/Net/SSH2.php");
	require_once('MinecraftServerStatus.class.php');

if (strpos(strtolower(PHP_OS), "Darwin") === false)
	$loads = sys_getloadavg();
else
	$loads = Array(0.55,0.7,1);

$ereborTotalSpace = 8.96102e12; // This is in bytes
$televisionTotalSpace = 5.95935e12; // This is in bytes
$television2TotalSpace = 5.95935e12; // This is in bytes
$television3TotalSpace = 4.99178e12; // This is in bytes

function getCpuUsage()
{
	$top = shell_exec('top -l 1 -n 0');
	$findme = 'idle';
	$cpuIdleStart = strpos($top, $findme);
	$cpuIdle = substr($top, ($cpuIdleStart - 7), 2);
	$cpuUsage = 100 - $cpuIdle;
	return $cpuUsage;
}

function makeCpuBars()
{
	printBar(getCpuUsage(), "Usage");
}	

function makeTotalDiskSpace()
{
	$du = getDiskspaceUsed("/") + getDiskspaceUsed("/Volumes/Isengard") + getDiskspaceUsed("/Volumes/WD2.1") + getDiskspaceUsed("/Volumes/Erebor") + getDiskspaceUsed("/Volumes/Television") + getDiskspaceUsed("/Volumes/Television 2") + getDiskspaceUsed("/Volumes/Storage space");
	$dts = disk_total_space("/") + disk_total_space("/Volumes/Isengard") + disk_total_space("/Volumes/WD2.1") + $GLOBALS['ereborTotalSpace'] + $GLOBALS['televisionTotalSpace'] + $GLOBALS['television2TotalSpace'] + $GLOBALS['television3TotalSpace'];
	$dup = $dts - $du;
	printDiskBarTotal(sprintf('%.0f',($du / $dts) * 100), "Total Disk Space", $du, $dts);
}

function byteFormat($bytes, $unit = "", $decimals = 2) {
	$units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 
			'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);
 
	$value = 0;
	if ($bytes > 0) {
		// Generate automatic prefix by bytes 
		// If wrong prefix given
		if (!array_key_exists($unit, $units)) {
			$pow = floor(log($bytes)/log(1024));
			$unit = array_search($pow, $units);
		}
 
		// Calculate byte value by prefix
		$value = ($bytes/pow(1024,floor($units[$unit])));
	}
 
	// If decimals is not numeric or decimals is less than 0 
	// then set default value
	if (!is_numeric($decimals) || $decimals < 0) {
		$decimals = 2;
	}
 
	// Format output
	return sprintf('%.' . $decimals . 'f '.$unit, $value);
  }

function makeDiskBars()
{
	printDiskBarGB(getDiskspace("/"), "SSD", getDiskspaceUsed("/"), disk_total_space("/"));
	printDiskBarGB(getDiskspace("/Volumes/Isengard"), "Isengard", getDiskspaceUsed("/Volumes/Isengard"), disk_total_space("/Volumes/Isengard"));
	printDiskBar(getDiskspace("/Volumes/WD2.1"), "Minas Morgul", getDiskspaceUsed("/Volumes/WD2.1"), disk_total_space("/Volumes/WD2.1"));
	printDiskBar(getDiskspaceErebor("/Volumes/Erebor"), "Erebor", getDiskspaceUsed("/Volumes/Erebor"), 8.96102e12);
	printDiskBar(getDiskspaceTV1("/Volumes/Television"), "Narya", getDiskspaceUsed("/Volumes/Television"), 5.95935e12);
	printDiskBar(getDiskspaceTV2("/Volumes/Television 2"), "Nenya", getDiskspaceUsed("/Volumes/Television 2"), 5.95935e12);
	printDiskBar(getDiskspaceTV3("/Volumes/Storage space"), "Vilya", getDiskspaceUsed("/Volumes/Storage space"), 4.99178e12);
}

function makeRamBars()
{
	printRamBar(getFreeRam()[0],getFreeRam()[1],getFreeRam()[2],getFreeRam()[3]);
}

function makeLoadBars()
{
	printBar(getLoad(0), "1 min");
	printBar(getLoad(1), "5 min");
	printBar(getLoad(2), "15 min");
}

function getFreeRam()
{
	$top = shell_exec('top -l 1 -n 0');
	$findme = 'PhysMem:';
	$physMemStart = strpos($top, $findme);
	$wiredRam = (substr($top, ($physMemStart + 9), 4))/1024; // GB
	$activeRam = (substr($top, ($physMemStart + 22), 4))/1024; // GB
	$totalRam = (substr(shell_exec('sysctl hw.memsize'), 12))/1024/1024/1024; // GB
	$usedRam = $wiredRam + $activeRam; // Find how much ram is used.
	return array (sprintf('%.0f',($usedRam / $totalRam) * 100), 'Used Ram', $usedRam, $totalRam);
}

function getDiskspace($dir)
{
	$df = disk_free_space($dir);
	$dt = disk_total_space($dir);
	$du = $dt - $df;
	return sprintf('%.0f',($du / $dt) * 100);
}

function getDiskspaceErebor($dir)
{
	$df = disk_free_space($dir);
	$dt = disk_total_space($dir);
	$du = $dt - $df;
	return sprintf('%.0f',($du / 8.96102e12) * 100);
}

function getDiskspaceUsed($dir)
{
	$df = disk_free_space($dir);
	$dt = disk_total_space($dir);
	$du = $dt - $df;
	return $du;
}

function getDiskspaceTV1($dir)
{
	$df = disk_free_space($dir);
	$dt = disk_total_space($dir);
	$du = $dt - $df;
	return sprintf('%.0f',($du / 5.95935e12) * 100);
}

function getDiskspaceTV2($dir)
{
	$df = disk_free_space($dir);
	$dt = disk_total_space($dir);
	$du = $dt - $df;
	return sprintf('%.0f',($du / 5.95935e12) * 100);
}

function getDiskspaceTV3($dir)
{
	$df = disk_free_space($dir);
	$dt = disk_total_space($dir);
	$du = $dt - $df;
	return sprintf('%.0f',($du / 4.99178e12) * 100);
}

function getLoad($id)
{
	return 100 * ($GLOBALS['loads'][$id] / 8);
}

function printBar($value, $name = "")
{
	if ($name != "") echo '<!-- ' . $name . ' -->';
	echo '<div class="exolight">';
		if ($name != "")
			echo $name . ": ";
			echo number_format($value, 0) . "%";
		echo '<div class="progress">';
			echo '<div class="progress-bar" style="width: ' . $value . '%"></div>';
		echo '</div>';
	echo '</div>';
}

function printRamBar($percent, $name = "", $used, $total)
{
	if ($percent < 90)
	{
		$progress = "progress-bar";
	}
	else if (($percent >= 90) && ($percent < 95))
	{
		$progress = "progress-bar progress-bar-warning";
	}
	else
	{
		$progress = "progress-bar progress-bar-danger";
	}

	if ($name != "") echo '<!-- ' . $name . ' -->';
	echo '<div class="exolight">';
		if ($name != "")
			echo $name . ": ";
			echo number_format($percent, 0) . "%";
		echo '<div rel="tooltip" data-toggle="tooltip" data-placement="bottom" title="' . number_format($used, 2) . ' GB / ' . number_format($total, 0) . ' GB" class="progress">';
			echo '<div class="'. $progress .'" style="width: ' . $percent . '%"></div>';
		echo '</div>';
	echo '</div>';
}

function printDiskBarTotal($dup, $name = "", $dsu, $dts)
{
	if ($dup < 90)
	{
		$progress = "progress-bar";
	}
	else if (($dup >= 90) && ($dup < 95))
	{
		$progress = "progress-bar progress-bar-warning";
	}
	else
	{
		$progress = "progress-bar progress-bar-danger";
	}
	
	if ($name != "") echo '<!-- ' . $name . ' -->';
	echo '<div class="exolight">';
		if ($name != "")
			echo $name . ": ";
			echo number_format($dup, 0) . "%";
		echo '<div rel="tooltip" data-toggle="tooltip" data-placement="bottom" title="' . byteFormat($dsu, "TB", 2) . ' / ' . byteFormat($dts, "TB", 2) . '" class="progress">';
			echo '<div class="'. $progress .'" style="width: ' . $dup . '%"></div>';
		echo '</div>';
	echo '</div>';
}

function printDiskBar($dup, $name = "", $dsu, $dts)
{
	if ($dup < 90)
	{
		$progress = "progress-bar";
	}
	else if (($dup >= 90) && ($dup < 95))
	{
		$progress = "progress-bar progress-bar-warning";
	}
	else
	{
		$progress = "progress-bar progress-bar-danger";
	}

	if ($name != "") echo '<!-- ' . $name . ' -->';
	echo '<div class="exolight">';
		if ($name != "")
			echo $name . ": ";
			echo number_format($dup, 0) . "%";
		echo '<div rel="tooltip" data-toggle="tooltip" data-placement="bottom" title="' . byteFormat($dsu, "TB", 2) . ' / ' . byteFormat($dts, "TB", 2) . '" class="progress">';
			echo '<div class="'. $progress .'" style="width: ' . $dup . '%"></div>';
		echo '</div>';
	echo '</div>';
}

function printDiskBarGB($dup, $name = "", $dsu, $dts)
{
	if ($dup < 90)
	{
		$progress = "progress-bar";
	}
	else if (($dup >= 90) && ($dup < 95))
	{
		$progress = "progress-bar progress-bar-warning";
	}
	else
	{
		$progress = "progress-bar progress-bar-danger";
	}

	if ($name != "") echo '<!-- ' . $name . ' -->';
	echo '<div class="exolight">';
		if ($name != "")
			echo $name . ": ";
			echo number_format($dup, 0) . "%";
		echo '<div rel="tooltip" data-toggle="tooltip" data-placement="bottom" title="' . byteFormat($dsu, "GB", 0) . ' / ' . byteFormat($dts, "GB", 0) . '" class="progress">';
			echo '<div class="'. $progress .'" style="width: ' . $dup . '%"></div>';
		echo '</div>';
	echo '</div>';
}

function ping()
{
	$clientIP = get_client_ip();
	$pingIP = '8.8.8.8';
	if($clientIP != '10.0.1.1') {
		$pingIP = $clientIP;
	}
	$terminal = shell_exec('ping -c 5 '.$pingIP);
	$findme = 'dev =';
	$start = strpos($terminal, $findme);
	$avgPing = substr($terminal, ($start +13), 2);
	return $avgPing;
}

function getNetwork()
{
	$clientIP = get_client_ip();
	if($clientIP=='10.0.1.1'):
		$network='http://10.0.1.3';
	else:
		$network='http://d4rk.co';
	endif;
	return $network;
}

function get_client_ip() 
{
	if ( isset($_SERVER["REMOTE_ADDR"])) { 
		$ipaddress = $_SERVER["REMOTE_ADDR"];
	}else if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		$ipaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
		$ipaddress = $_SERVER["HTTP_CLIENT_IP"];
	} 
	return $ipaddress;
}

function makeRecenlyPlayed()
{
	$plexSessionXML = simplexml_load_file('http://10.0.1.3:32400/status/sessions');
	$clientIP = get_client_ip();

	$network = getNetwork();
	$trakt_url = 'http://trakt.tv/user/d4rk/widgets/watched/all-tvthumb.jpg';
	$traktThumb = '/Users/zeus/Sites/d4rk.co/assets/misc/all-tvthumb.jpg';

	echo '<div class="col-md-12">';
	echo '<a href="http://trakt.tv/user/d4rk" class="thumbnail">';
	if (file_exists($traktThumb) && (filemtime($traktThumb) > (time() - 60 * 15))) {
		// Trakt image is less than 15 minutes old.
		// Don't refresh the image, just use the file as-is.
		echo '<img src="'.$network.'/assets/misc/all-tvthumb.jpg" alt="trakt.tv" class="img-responsive"></a>';
	} else {
		// Either file doesn't exist or our cache is out of date,
		// so check if the server has different data,
		// if it does, load the data from our remote server and also save it over our cache for next time.
		$thumbFromTrakt_md5 = md5_file($trakt_url);
		$traktThumb_md5 = md5_file($traktThumb);
		if ($thumbFromTrakt_md5 === $traktThumb_md5) {
			echo '<img src="'.$network.'/assets/misc/all-tvthumb.jpg" alt="trakt.tv" class="img-responsive"></a>';
		} else {
			$thumbFromTrakt = file_get_contents($trakt_url);
			file_put_contents($traktThumb, $thumbFromTrakt, LOCK_EX);
			echo '<img src="'.$network.'/assets/misc/all-tvthumb.jpg" alt="trakt.tv" class="img-responsive"></a>';

		}
	}
	if($clientIP == '10.0.1.1' && count($plexSessionXML->Video) == 0) {
		echo '<hr>';
		echo '<h1 class="exoextralight" style="margin-top:5px;">';
		echo 'Forecast</h1>';
		echo '<iframe id="forecast_embed" type="text/html" frameborder="0" height="245" width="100%" src="http://forecast.io/embed/#lat=40.7838&lon=-96.622773&name=Lincoln, NE"> </iframe>';
	}
	echo '</div>';
}

function makeRecenlyReleased()
{
	$plexToken = 'pastPlextokenhere';	// You can get your Plex token using the getPlexToken() function. This will be automated once I find out how often the token has to be updated.
	$plexNewestXML = simplexml_load_file('http://10.0.1.3:32400/library/sections/7/newest');
	$clientIP = get_client_ip();
	$network = getNetwork();
	
	echo '<div class="col-md-12">';
	echo '<div class="thumbnail">';
	echo '<div id="carousel-example-generic" class=" carousel slide">';
	//echo '<!-- Indicators -->';
	//echo '<ol class="carousel-indicators">';
	//echo '<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>';
	//echo '<li data-target="#carousel-example-generic" data-slide-to="1"></li>';
	//echo '<li data-target="#carousel-example-generic" data-slide-to="2"></li>';
	//echo '</ol>';
	echo '<!-- Wrapper for slides -->';
	echo '<div class="carousel-inner">';
	echo '<div class="item active">';
	$mediaKey = $plexNewestXML->Video[0]['key'];
	$mediaXML = simplexml_load_file('http://10.0.1.3:32400'.$mediaKey);
	$movieTitle = $mediaXML->Video['title'];
	$movieArt = $mediaXML->Video['thumb'];
	echo '<img src="'.$network.':32400'.$movieArt.'?X-Plex-Token='.$plexToken.'" alt="...">';
	echo '</div>'; // Close item div
	$i=1;
	for ( ; ; ) {
		if($i==15) break;
		$mediaKey = $plexNewestXML->Video[$i]['key'];
		$mediaXML = simplexml_load_file('http://10.0.1.3:32400'.$mediaKey);
		$movieTitle = $mediaXML->Video['title'];
		$movieArt = $mediaXML->Video['thumb'];
		$movieYear = $mediaXML->Video['year'];
		echo '<div class="item">';
		echo '<img src="'.$network.':32400'.$movieArt.'?X-Plex-Token='.$plexToken.'" alt="...">';
		//echo '<div class="carousel-caption">';
		//echo '<h3>'.$movieTitle.$movieYear.'</h3>';
		//echo '<p>Summary</p>';
		//echo '</div>';
		echo '</div>'; // Close item div
		$i++;
	}
	echo '</div>'; // Close carousel-inner div

	echo '<!-- Controls -->';
	echo '<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">';
	//echo '<span class="glyphicon glyphicon-chevron-left"></span>';
	echo '</a>';
	echo '<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">';
	//echo '<span class="glyphicon glyphicon-chevron-right"></span>';
	echo '</a>';
	echo '</div>'; // Close carousel slide div
	echo '</div>'; // Close thumbnail div

	//if($clientIP == '10.0.1.1' && count($plexSessionXML->Video) == 0) {
	//	echo '<hr>';
	//	echo '<h1 class="exoextralight" style="margin-top:5px;">';
	//	echo 'Forecast</h1>';
	//	echo '<iframe id="forecast_embed" type="text/html" frameborder="0" height="245" width="100%" src="http://forecast.io/embed/#lat=40.7838&lon=-96.622773&name=Lincoln, NE"> </iframe>';
	//}
	echo '</div>'; // Close column div
}

function makeNowPlaying()
{
	$plexToken = 'pastPlextokenhere';	// You can get your Plex token using the getPlexToken() function. This will be automated once I find out how often the token has to be updated.
	$network = getNetwork();
	$plexSessionXML = simplexml_load_file('http://10.0.1.3:32400/status/sessions');

	if (count($plexSessionXML->Video) == 0):
		makeRecenlyReleased();
	else:
		$i = 0; // Initiate and assign a value to i & t
		$t = 0;
		echo '<div class="col-md-10 col-sm-offset-1">';
		foreach ($plexSessionXML->Video as $sessionInfo):
			$t++;
		endforeach;
		foreach ($plexSessionXML->Video as $sessionInfo):
			$mediaKey=$sessionInfo['key'];
			$playerTitle=$sessionInfo->Player['title'];
			$mediaXML = simplexml_load_file('http://10.0.1.3:32400'.$mediaKey);
			$type=$mediaXML->Video['type'];
			echo '<div class="thumbnail">';
			$i++; // Increment i every pass through the array
			if ($type == "movie"):
				// Build information for a movie
				$movieArt = $mediaXML->Video['thumb'];
				echo '<img src="'.$network.':32400'.$movieArt.'?X-Plex-Token='.$plexToken.'" alt="thumbnail">';
				echo '<div class="caption">';
				$movieTitle = $mediaXML->Video['title'];
				//echo '<h2 class="exoextralight">'.$movieTitle.'</h2>';
				if (strlen($mediaXML->Video['summary']) < 800):
					$movieSummary = $mediaXML->Video['summary'];
				else:
					$movieSummary = substr_replace($mediaXML->Video['summary'], '...', 800);
				endif;

				echo '<p class="exolight" style="margin-top:5px;">'.$movieSummary.'</p>';
			else:
				// Build information for a tv show
				$tvArt = $mediaXML->Video['grandparentThumb'];
				echo '<img src="'.$network.':32400'.$tvArt.'?X-Plex-Token='.$plexToken.'" alt="thumbnail">';
				echo '<div class="caption">';
				$showTitle = $mediaXML->Video['grandparentTitle'];
				$episodeTitle = $mediaXML->Video['title'];
				$episodeSummary = $mediaXML->Video['summary'];
				$episodeSeason = $mediaXML->Video['parentIndex'];
				$episodeNumber = $mediaXML->Video['index'];
				//echo '<h2 class="exoextralight">'.$showTitle.'</h2>';
				echo '<h3 class="exoextralight" style="margin-top:5px;">Season '.$episodeSeason.'</h3>';
				echo '<h4 class="exoextralight" style="margin-top:5px;">E'.$episodeNumber.' - '.$episodeTitle.'</h4>';
				echo '<p class="exolight">'.$episodeSummary.'</p>';
			endif;
			// Action buttons if we ever want to do something
			//echo '<p><a href="#" class="btn btn-primary">Action</a> <a href="#" class="btn btn-default">Action</a></p>';
			echo "</div>";
			echo "</div>";
			// Should we make <hr>? Only if there is more than one video and it's not the last thumbnail created.
			if (($i > 0) && ($i < $t)):
				echo '<hr>';
			else:
				// Do nothing
			endif;
		endforeach;
		echo '</div>';
	endif;
}

function makeBandwidthBars()
{
	$array = getBandwidth();
	$dPercent = sprintf('%.0f',($array[0] / 55) * 100);
	$uPercent = sprintf('%.0f',($array[1] / 5) * 100);
	printBandwidthBar($dPercent, 'Download', $array[0]);
	printBandwidthBar($uPercent, 'Upload', $array[1]);
}

function getBandwidth()
{
	$ssh = new Net_SSH2('10.0.1.1');
	if (!$ssh->login('username', 'password')) { // replace password and username with pfSense ssh username and password if you want to use this
		exit('Login Failed');
	}

	$dump = $ssh->exec('vnstat -i nve0 -tr');
	$output = preg_split('/[,;| \s]/', $dump);
	for ($i=count($output)-1; $i>=0; $i--) {
		if ($output[$i] == '') unset ($output[$i]);
	}
	$output = array_values($output);
	$rxRate = $output[51];
	$rxFormat = $output[52];
	$txRate = $output[56];
	$txFormat = $output[57];
	if ($rxFormat == 'kbit/s') {
		$rxRateMB = $rxRate / 1024;
	} else {
		$rxRateMB = $rxRate;
	}
	if ($txFormat == 'kbit/s') {
		$txRateMB = $txRate / 1024;
	} else {
		$txRateMB = $txRate;
	}
	return  array($rxRateMB, $txRateMB);
}

function printBandwidthBar($percent, $name = "", $Mbps)
{
	if ($name != "") echo '<!-- ' . $name . ' -->';
	echo '<div class="exolight">';
		if ($name != "")
			echo $name . ": ";
			echo number_format($Mbps, 2) . " Mbps";
		echo '<div class="progress">';
			echo '<div class="progress-bar" style="width: ' . $percent . '%"></div>';
		echo '</div>';
	echo '</div>';
}

function getMinecraftPlayers($port)
{
	$server = new MinecraftServerStatus('127.0.0.1',$port);
	$players = false;
	$numplayers = 0;
	if($server->Get('numplayers')>"0") {
		$players = true;
		$numplayers = $server->Get('numplayers');
	}

	return array($players, $numplayers);
}

function getPlexToken()
{
	$myPlex = shell_exec('curl -H "Content-Length: 0" -H "X-Plex-Client-Identifier: my-app" -u"usernameoremailformyPlex":"password" -X POST https://my.plexapp.com/users/sign_in.xml');
	return $myPlex;
}

function getDir($b)
{
   $dirs = array('N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW', 'N');
   return $dirs[round($b/45)];
}

function makeWeatherSidebar()
{
	$forecastAPI = 'INSERT FORECAST API NUMBER HERE, ITS FREE';
	$forecastExcludes = '?exclude=daily,flags';
	// Lincoln, NE lat/long = 40.784007 -96.620592
	$forecastLat = '40.784007';
	$forecastLong = '-96.620592';
	$currentForecast = json_decode(file_get_contents('https://api.forecast.io/forecast/'.$forecastAPI.'/'.$forecastLat.','.$forecastLong.$forecastExcludes));

	$currentSummary = $currentForecast->currently->summary;
	$currentSummaryIcon = $currentForecast->currently->icon;
	$currentTemp = round($currentForecast->currently->temperature);
	$currentWindSpeed = round($currentForecast->currently->windSpeed);
	if ($currentWindSpeed > 0) {
		$currentWindBearing = $currentForecast->currently->windBearing;
	}
	$minutelySummary = $currentForecast->minutely->summary;
	$hourlySummary = $currentForecast->hourly->summary;
	// If there are alerts, make the alerts variables
	if (isset($currentForecast->alerts)) {
		$alertTitle = $currentForecast->alerts[0]->title;
		$alertExpires = $currentForecast->alerts[0]->expires;
		$alertDescription = $currentForecast->alerts[0]->description;
		$alertUri = $currentForecast->alerts[0]->uri;
	}
	// Make the array for weather icons
	$weatherIcons = [
		'clear-day' => 'B',
		'clear-night' => 'C',
		'rain' => 'R',
		'snow' => 'W',
		'sleet' => 'X',
		'wind' => 'F',
		'fog' => 'L',
		'cloudy' => 'N',
		'partly-cloudy-day' => 'H',
		'partly-cloudy-night' => 'I',
	];
	$weatherIcon = $weatherIcons[$currentSummaryIcon];
	// If there is a severe weather warning, display it
	//if (isset($currentForecast->alerts)) {
	//	echo '<div class="alert alert-warning alert-dismissable">';
	//	echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
	//	echo '<strong><a href="'.$alertUri.'" class="alert-link">'.$alertTitle.'</a></strong>';
	//	echo '</div>';
	//}
	echo '<ul class="list-inline" style="margin-bottom:-20px">';
	echo '<li><h1 data-icon="'.$weatherIcon.'" style="font-size:500%;margin:0px -10px 20px -5px"></h1></li>';
	echo '<li><ul class="list-unstyled">';
	echo '<li><h1 class="exoregular" style="margin:0px">'.$currentTemp.'°</h1></li>';
	echo '<li><h4 class="exoregular" style="margin:0px;padding-right:10px;width:80px">'.$currentSummary.'</h4></li>';
	echo '</ul></li>';
	echo '</ul>';
	//if ($currentWindSpeed > 0) {
	//	$direction = getDir($currentWindBearing);
	//	echo '<h4 class="exoextralight" style="margin-top:0px">Wind: '.$currentWindSpeed.' mph ('.$direction.')</h4>';
	//}
	echo '<h4 class="exoregular">Next Hour</h4>';
	echo '<h5 class="exoextralight" style="margin-top:10px">'.$minutelySummary.'</h5>';
	echo '<h4 class="exoregular">Next 24 Hours</h4>';
	echo '<h5 class="exoextralight" style="margin-top:10px">'.$hourlySummary.'</h5>';
	echo '<p class="text-right no-link-color"><small><a href="http://forecast.io/#/f/40.7838,-96.622773">Forecast.io</a></small></p> ';
}

?>