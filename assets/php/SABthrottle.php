
<?php

	$config_path = "/Users/zeus/Sites/config.ini"; //path to config file, recommend you place it outside of web root

	Ini_Set( 'display_errors', true );
	$config = parse_ini_file($config_path);

	$sabnzbd_api = $config['sabnzbd_api'];
	$ping_throttle = $config['ping_throttle'];
	$sabSpeedLimitMax = $config['sabSpeedLimitMax'];
	$sabSpeedLimitMin = $config['sabSpeedLimitMin'];

function ping()
{
	$pingIP = '8.8.8.8';
	
	$terminal_output = shell_exec('ping -c 5 '.$pingIP);
	// If using something besides OS X you might want to customize the following variables for proper output of average ping.
	$findme_start = '= ';
	$start = strpos($terminal_output, $findme_start);
	$ping_return_value_str = substr($terminal_output, ($start +2), 100);
	$findme_stop = '.';
	$stop = strpos($ping_return_value_str, $findme_stop);
	$avgPing = substr($ping_return_value_str, ($stop + 5), $stop);
	return $avgPing;
}

function sabSpeedAdjuster()
{
	global $sabnzbd_api;
	global $sabSpeedLimitMax;
	global $sabSpeedLimitMin;
	// Set how high ping we want to hit before throttling
	global $ping_throttle;

	// Check the current ping
	$avgPing = ping();
	// Get SABnzbd XML
	$sabnzbdXML = simplexml_load_file('http://10.0.1.3:8080/api?mode=queue&start=START&limit=LIMIT&output=xml&apikey='.$sabnzbd_api);
	// Get current SAB speed limit
	$sabSpeedLimitCurrent = $sabnzbdXML->speedlimit;
	
	// Check to see if SAB is downloading
	if (($sabnzbdXML->status) == 'Downloading'):
			// If it is downloading and ping is over X value, slow it down
			if ($avgPing > $ping_throttle):
				if ($sabSpeedLimitCurrent > $sabSpeedLimitMin):
					// Reduce speed by 256KBps
					echo 'Ping is over '.$ping_throttle;
					echo '<br>';
					echo 'Slowing down SAB';
					$sabSpeedLimitSet = $sabSpeedLimitCurrent - 256;
					shell_exec('curl "http://10.0.1.3:8080/api?mode=config&name=speedlimit&value='.$sabSpeedLimitSet.'&apikey='.$sabnzbd_api.'"');
				else:
					echo 'Ping is over '.$ping_throttle.' but SAB cannot slow down anymore';
				endif;	
			elseif (($avgPing + 9) < $ping_throttle):
				if ($sabSpeedLimitCurrent < $sabSpeedLimitMax):
					// Increase speed by 256KBps
					echo 'SAB is downloading and ping is '.($avgPing + 9).'  so increasing download speed.';
					$sabSpeedLimitSet = $sabSpeedLimitCurrent + 256;
					shell_exec('curl "http://10.0.1.3:8080/api?mode=config&name=speedlimit&value='.$sabSpeedLimitSet.'&apikey='.$sabnzbd_api.'"');
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
}

	sabSpeedAdjuster();
?>

