<!DOCTYPE html>
<html lang="en">
	<script>
	// Enable bootstrap tooltips
	$(function ()
	        { $("[rel=tooltip]").tooltip();
	        });
	</script>
<?php require_once('MinecraftServerStatus.class.php');
$Server_MC = new MinecraftServerStatus('127.0.0.1',25564); ?>
<!-- MC Online Players -->
<?php if($Server_MC->Get('numplayers')>"0"): ?>
<?php foreach($Server_MC->Get('players') as $Player_MC)
if (file_exists('/Users/zeus/Sites/d4rk.co/mc/img/avatars/' . $Player_MC . '.png')) {
	echo '<img src="/mc/img/avatars/' . $Player_MC . '.png" rel="tooltip" data-toggle="tooltip" title="' . $Player_MC . '" style="margin-right: 1px; margin-left: 1px" class="img-polaroid">';
} else {
	$f = file_put_contents("/Users/zeus/Sites/d4rk.co/mc/img/avatars/" . $Player_MC . ".png", fopen("https://minotar.net/helm/" . $Player_MC . "/30.png", 'r'));
	if($f) {
		echo '<img src="/mc/img/avatars/' . $Player_MC . '.png" rel="tooltip" data-toggle="tooltip" title="' . $Player_MC . '" style="margin-right: 1px; margin-left: 1px" class="img-polaroid">';
	} else {
		echo '<p>Unable to download avatar</p>';
	}
} endif ?>