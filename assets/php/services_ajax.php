<!DOCTYPE html>
<?php
	Ini_Set( 'display_errors', true );
	include '../../init.php';
	include ROOT_DIR . '/assets/php/functions.php';
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
$sabnzbdXML = simplexml_load_file('http://'.$sab_ip.':'.$sab_port.'/api?mode=qstatus&output=xml&apikey='.$sabnzbd_api);

if (($sabnzbdXML->state) == 'Downloading'):
	$timeleft = $sabnzbdXML->timeleft;
	$sabTitle = 'SABnzbd ('.$timeleft.')';
else:
	$sabTitle = 'SABnzbd';
endif;

$services = array(
	new service("Plex", 32400, "http://d4rk.co:32400/web/index.html#!/dashboard"),
	//new service("pfSense", 8082, "http://d4rk.co:8082", "d4rk.co"),
	new serviceSAB($sabTitle, 8080, "http://d4rk.co:8080", "10.0.1.5"),
	new service("SickBeard", 8081, "http://d4rk.co:8081", "10.0.1.3"),
	new service("CouchPotato", 5050, "http://d4rk.co:5050", "10.0.1.3"),
	new service("Transmission", 9091, "http://d4rk.co:9091", "10.0.1.5"),
	new service("iTunes Server", 3689, "http://www.apple.com/itunes/"),
	//new service("Starbound Server", 21025, "http://playstarbound.com"),
	new serviceMinecraft("Vanilla", 25564, "http://minecraft.d4rk.co", "mc.d4rk.co"),
	new serviceMinecraft("Bevo Tech Pack", 25565, "http://minecraft.d4rk.co")
);
?>
<table class="center">
	<?php foreach($services as $service){ ?>
		<tr>
			<td style="text-align: right; padding-right:5px;" class="exoextralight"><?php echo $service->name; ?></td>
			<td style="text-align: left;"><?php echo $service->makeButton(); ?></td>
		</tr>
	<?php }?>
</table>