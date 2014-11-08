		<h4 class="panel-title exoextralight"
		<?php
			Ini_Set( 'display_errors', true );
			include '../../init.php';
			include 'functions.php';
			
		$transcodeSessions = getTranscodeSessions();

		if ($transcodeSessions > 0) {
			echo ' style="margin-left:23px"';
		};
		?>
		>
		<?php
		if ($transcodeSessions > 0) {
			echo '<span id="transcodeSessions" class="badge pull-right" rel="tooltip" data-toggle="tooltip" data-placement="bottom" title="Transcode Sessions" style="width:23px">'.$transcodeSessions.'</span>';
		};
		?>
		Load
		</h4>
		<script>
			// Enable bootstrap tooltips
			$(function ()
			        { $("[rel=tooltip]").tooltip();
			        });
		</script>