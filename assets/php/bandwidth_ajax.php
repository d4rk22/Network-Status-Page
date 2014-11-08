<!DOCTYPE html>
<?php
	Ini_Set( 'display_errors', true );
	include '../../init.php';
	include ROOT_DIR . '/assets/php/functions.php';
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

?>