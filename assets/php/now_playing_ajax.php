<?php
	Ini_Set( 'display_errors', true );
	include '../../init.php';
	include ROOT_DIR . '/assets/php/functions.php';

makeNowPlaying();
?>
<script>
	// Enable bootstrap tooltips
	$(function ()
		{ $("[rel=tooltip]").tooltip();
	});

	$('.carousel').carousel({
  		interval: 30000
	})
</script>