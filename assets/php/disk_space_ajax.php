<!DOCTYPE html>
<?php
	Ini_Set( 'display_errors', false);
	include("functions.php");
?>
<html lang="en">
	<script>
	// Enable bootstrap tooltips
	$(function ()
	        { $("[rel=tooltip]").tooltip();
	        });
	</script>
	<!-- Disk Space -->
<h4 class="exoextralight">Disk space</h4>
<?php makeTotalDiskSpace(); ?>
<hr>
<?php makeDiskBars(); ?>