<?php
	// This is a standalone function that I'm including with Network Status Page.
	// It monitors the ping between your network and Google's DNS and then adjusts the speed limit of SABnzbd+ according to preference.
	// While it is standalone php file it still points to the same configuration file that comes with Network Status Page so you can
	// easily adjust preferences there. I simply made this not have any includes so that
	// you could move it to wherever is most convenient for scripts.
	$config_path = "/Users/zeus/Sites/config.ini"; //path to config file, recommend you place it outside of web root

	Ini_Set( 'display_errors', true );
	$config = parse_ini_file($config_path);

	$sabnzbd_api = $config['sabnzbd_api'];
	$sab_ip = $config['sab_ip'];
	$sab_port = $config['sab_port'];
	$ping_throttle = $config['ping_throttle'];
	$sabSpeedLimitMax = $config['sabSpeedLimitMax'];
	$sabSpeedLimitMin = $config['sabSpeedLimitMin'];
	$ping_ip = $config['ping_ip'];

function ping()
{
	global $ping_ip;
	
	$terminal_output = shell_exec('ping -c 10 -q '.$ping_ip);
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
	global $sab_ip;
	global $sab_port;
	global $sabnzbd_api;
	global $sabSpeedLimitMax;
	global $sabSpeedLimitMin;
	// Set how high ping we want to hit before throttling
	global $ping_throttle;

	// Check the current ping
	$avgPing = ping();
	// Get SABnzbd XML
	$sabnzbdXML = simplexml_load_file('http://'.$sab_ip.':'.$sab_port.'/api?mode=queue&start=START&limit=LIMIT&output=xml&apikey='.$sabnzbd_api);
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
					shell_exec('curl "http://'.$sab_ip.':'.$sab_port.'/api?mode=config&name=speedlimit&value='.$sabSpeedLimitSet.'&apikey='.$sabnzbd_api.'"');
				else:
					echo 'Ping is over '.$ping_throttle.' but SAB cannot slow down anymore';
				endif;	
			elseif (($avgPing + 9) < $ping_throttle):
				if ($sabSpeedLimitCurrent < $sabSpeedLimitMax):
					// Increase speed by 256KBps
					echo 'SAB is downloading and ping is '.($avgPing + 9).'  so increasing download speed.';
					$sabSpeedLimitSet = $sabSpeedLimitCurrent + 256;
					shell_exec('curl "http://'.$sab_ip.':'.$sab_port.'/api?mode=config&name=speedlimit&value='.$sabSpeedLimitSet.'&apikey='.$sabnzbd_api.'"');
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

