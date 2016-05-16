<!DOCTYPE html>
<?php
	Ini_Set( 'display_errors', true );
	include '../../init.php';
	include ROOT_DIR . '/assets/php/functions.php';

	// Import variables from config file
	$config_path = '/Library/Server/Web/Data/Sites/config.ini'; //path to config file, recommend you place it outside of web root
	$config = parse_ini_file($config_path);

	// Display Options
	$bandwidth_sidebar = $config['bandwidth_sidebar'];
	$weather_always_display = $config['weather_always_display'];
?>
<html lang="en">
	<script>
	// Enable bootstrap tooltips
	$(function ()
	        { $("[rel=tooltip]").tooltip();
	        });
	</script>
<?php 

global $wan1_ip;
global $wan2_ip;
global $ping_ip;

if ($bandwidth_sidebar = 'false'): 

else:

echo '<div class="exolight">';
echo 'WAN1 Ping: '.getping($wan1_ip,$ping_ip).' ms';
echo '<br>';
echo '';
echo '<br>';
makeBandwidthBars('rl1');
echo '<br>';
echo 'WAN2 Ping: '.getping($wan2_ip,$ping_ip).' ms';
echo '<br>';
echo '';
echo '<br>';
makeBandwidthBars('rl4');
echo '</div>';

endif;

?>