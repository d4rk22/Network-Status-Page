<!DOCTYPE html>
<?php
	Ini_Set( 'display_errors', true );
	include("functions.php");
	include("service.class.php");
	include("serviceSAB.class.php");
	include("serviceMinecraft.class.php");
?>
<html lang="en">
	<script>
	// Enable bootstrap tooltips
	$(function ()
	        { $("[rel=tooltip]").tooltip();
	        });
	</script>
<?php 
$sabnzbdXML = simplexml_load_file('http://10.0.1.3:8080/api?mode=qstatus&output=xml&apikey=d8f21cb16e5dd227e8e33909a2c4c081');

if (($sabnzbdXML->state) == 'Downloading'):
	$timeleft = $sabnzbdXML->timeleft;
	$sabTitle = 'SABnzbd ('.$timeleft.')';
else:
	$sabTitle = 'SABnzbd';
endif;

$services = array(
	new service("Plex", 32400, "http://d4rk.co:32400/web/index.html#!/dashboard"),
	new service("pfSense", 8082, "http://d4rk.co:8082", "d4rk.co"),
	new serviceSAB($sabTitle, 8080, "http://d4rk.co:8080", "10.0.1.3"),
	new service("SickBeard", 8081, "http://d4rk.co:8081"),
	new service("CouchPotato", 5050, "http://d4rk.co:5050"),
	new service("Transmission", 9091, "http://d4rk.co:9091"),
	new service("iTunes Server", 3689),
	new serviceMinecraft("Minecraft Server", 25564, "http://d4rk.co/mc"),
	new serviceMinecraft("Feed the Beast Server", 25565, "http://d4rk.co/mc")
);
?>
<table>
	<?php foreach($services as $service){ ?>
		<tr>
			<td style="text-align: right; padding-right:5px;" class="exoextralight"><?php echo $service->name; ?></td>
			<td style="text-align: left;"><?php echo $service->makeButton(); ?></td>
		</tr>
	<?php }?>
</table>