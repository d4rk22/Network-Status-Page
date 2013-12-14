<!DOCTYPE html>
<html lang="en">
	<script>
	// Enable bootstrap tooltips
	$(function ()
	        { $("[rel=tooltip]").tooltip();
	        });
	</script>
<?php 

require_once('MinecraftServerStatus.class.php');
// Assign variables
$Server_FTB = new MinecraftServerStatus('127.0.0.1',25565);
// FTB Online Players
if($Server_FTB->Get('numplayers')>"0"):
	foreach($Server_FTB->Get('players') as $Player_FTB)
		$avatarLocal = '/Users/zeus/Sites/d4rk.co/mc/img/avatars/' . $Player_FTB . '.png';
		// If our local avatar file exists and is less than 24 hours old
		if (file_exists($avatarLocal) && (filemtime($avatarLocal) > (time() - 60 * 60 * 24))) {
			echo '<img src="/mc/img/avatars/' . $Player_FTB . '.png" rel="tooltip" data-toggle="tooltip" title="' . $Player_FTB . '" style="margin-right: 1px; margin-left: 1px" class="img-polaroid">';
		} else {
			$f = file_put_contents($avatarLocal, fopen("https://minotar.net/helm/" . $Player_FTB . "/30.png", 'r'));
			if($f) {
				echo '<img src="/mc/img/avatars/' . $Player_FTB . '.png" rel="tooltip" data-toggle="tooltip" title="' . $Player_FTB . '" style="margin-right: 1px; margin-left: 1px" class="img-polaroid">';
			} else {
				echo '<p>Unable to download avatar</p>';
			}
} endif 
?>