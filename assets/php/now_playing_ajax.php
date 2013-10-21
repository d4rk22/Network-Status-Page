<!DOCTYPE html>
<?php
	Ini_Set( 'display_errors', true );
	include("functions.php");
?>
<html lang="en">
	<script>
	// Enable bootstrap tooltips
	$(function ()
		{ $("[rel=tooltip]").tooltip();
	});

	$('.carousel').carousel({
  		interval: 30000
	})
	</script>
<?php
makeNowPlaying();
?>