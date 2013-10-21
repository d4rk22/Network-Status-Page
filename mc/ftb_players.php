<!DOCTYPE html>
<html lang="en">
	<script>
	// Enable bootstrap tooltips
	$(function ()
	        { $("[rel=tooltip]").tooltip();
	        });
	</script>
<?php require_once('MinecraftServerStatus.class.php');
$Server_FTB = new MinecraftServerStatus('127.0.0.1',25565); ?>
<!-- FTB Online Players -->
<?php if($Server_FTB->Get('numplayers')>"0"): ?>
<?php foreach($Server_FTB->Get('players') as $Player_FTB)
if (file_exists('/Users/zeus/Sites/d4rk.co/mc/img/avatars/' . $Player_FTB . '.png')) {
	echo '<img src="/mc/img/avatars/' . $Player_FTB . '.png" rel="tooltip" data-toggle="tooltip" title="' . $Player_FTB . '" style="margin-right: 1px; margin-left: 1px" class="img-polaroid">';
} else {
	$f = file_put_contents("/Users/zeus/Sites/d4rk.co/mc/img/avatars/" . $Player_FTB . ".png", fopen("https://minotar.net/helm/" . $Player_FTB . "/30.png", 'r'));
	if($f) {
		echo '<img src="/mc/img/avatars/' . $Player_FTB . '.png" rel="tooltip" data-toggle="tooltip" title="' . $Player_FTB . '" style="margin-right: 1px; margin-left: 1px" class="img-polaroid">';
	} else {
		echo '<p>Unable to download avatar</p>';
	}
} endif 
?>