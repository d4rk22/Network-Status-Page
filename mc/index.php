<!DOCTYPE html>
<?php
	Error_Reporting( E_ALL | E_STRICT );
	Ini_Set( 'display_errors', false );
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>d4rk.co - Minecraft Servers</title>
		<meta name="author" content="d4rk">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Le styles -->
		<link href="/mc/css/bootstrap.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.css" rel="stylesheet">
		<!-- Google Fonts 
		<link href='http://fonts.googleapis.com/css?family=Quicksand:300' rel='stylesheet' type='text/css'> -->
		<!-- Custom Header font -->
		<style type="text/css">
			/* Custom header font 
			h1 { font-family: 'Quicksand', sans-serif;
			} */
			body {
			/* padding-top: 20px;
			padding-bottom: 20px;*/
			text-align: center;
			}
		</style>
		<link rel="shortcut icon" href="/mc/favicon.ico">
		<link rel="apple-touch-icon-precomposed" href="/mc/img/apple-touch-icon.png" />
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="/mc/js/bootstrap.min.js"></script>
		<!-- Javascript -->
		<script>
		// Enable bootstrap tooltips
		$(function ()
			{ $("[rel=tooltip]").tooltip();
			}); 
		// Auto refresh things
		(function($)
		{
			$(document).ready(function()
			{
				$.ajaxSetup(
				{
		            cache: false,
		            beforeSend: function() {
		                $('#ftb_status_buttons').show();
		                $('#ftb_players').show();
		                $('#mc_players').show();
		                $('#mc_status_buttons').show();
		            },
		            complete: function() {
		                $('#ftb_status_buttons').show();
		                $('#ftb_players').show();
		                $('#mc_status_buttons').show();
		                $('#mc_players').show();
		            },
		            success: function() {
		                $('#ftb_status_buttons').show();
		                $('#ftb_players').show();
		                $('#mc_status_buttons').show();
		                $('#mc_players').show();
		            }
		        });
		        var $ftb_status_refresh = $('#ftb_status_buttons');
		        var $ftb_players_refresh = $('#ftb_players');
		        var $mc_status_refresh = $('#mc_status_buttons');
		        var $mc_players_refresh = $('#mc_players');

		        $ftb_status_refresh.load('ftb_status_buttons.php');
		        $ftb_players_refresh.load('ftb_players.php');
		        $mc_status_refresh.load('mc_status_buttons.php');
		        $mc_players_refresh.load('mc_players.php');
		        
		        var refreshId = setInterval(function()
		        {
		            $ftb_status_refresh.load('ftb_status_buttons.php');
		            $ftb_players_refresh.load('ftb_players.php');
		            $mc_status_refresh.load('mc_status_buttons.php');
		            $mc_players_refresh.load('mc_players.php');
		        }, 10000); //(10sec)

		    });
		})(jQuery);
		</script>
	</head>
	<body>
		<div class="page-header">
  			<h1>Minecraft Servers</h1>
		</div>
		<div class="container-fluid">
			<!-- FTB server title row -->
			<div class="row-fluid">
				<!-- FTB icon -->
				<div class="span6 offset3">
					<img src="/mc/img/ftb.png">
				</div>
			</div>
			<!-- FTB buttons row -->
			<div class="row-fluid">
				<!-- FTB buttons -->
				<div class="span6 offset3">
					<!-- button toolbar -->
					<div class="btn-toolbar">
						<!-- FTB status button group -->
						<div id="ftb_status_buttons" class="btn-group"></div>
						<!-- iPhone portrait fix -->
						<div class="visible-phone" style="margin-bottom:5px;"></div>
						<!-- links button group -->
						<div class="btn-group" style="margin-left:5px;">	
							<!-- FTB Map Link -->
							<a href="http://d4rk.co:8123" class="btn"><i class="icon-map-marker"></i> Map</a>
							<!-- FTB Chat Link -->
							<!--<a href="#" class="btn"><i class="icon-comment"></i> Chat</a>-->
							<!-- Button to trigger FTB modal -->
							<a href="#ftbModal" class="btn" data-toggle="modal"><i class="icon-info-sign"></i></a>
						</div>
					</div>
				</div>
			</div>
			<!-- FTB players row -->
			<div class="row-fluid" style="height:40px; margin-bottom:10px;">
				<!-- FTB Online Players -->
				<div id="ftb_players" class="span6 offset3"></div>
			</div>
			<!-- MC server title row -->
			<div class="row-fluid">
				<!-- Minecraft icon -->
				<div class="span6 offset3">
					<img src="/mc/img/mc.png">
				</div>
			</div>
			<!-- MC buttons row -->
			<div class="row-fluid">
				<!-- MC buttons -->
				<div class="span6 offset3">
					<!-- button toolbar -->
					<div class="btn-toolbar">
						<!-- status button group -->
						<div id="mc_status_buttons" class="btn-group"></div>
						<!-- iPhone portrait fix -->
						<div class="visible-phone" style="margin-bottom:5px;"></div>
						<!-- links button group -->
						<div class="btn-group" style="margin-left:5px;">	
							<!-- Map Link -->
							<a href="http://d4rk.co:8124" class="btn"><i class="icon-map-marker icon-white"></i> Map</a>
							<!-- Button to trigger MC modal -->
							<a href="#mcModal" class="btn" data-toggle="modal"><i class="icon-info-sign"></i></a>
						</div>
					</div>
				</div>
			</div>
			<!-- MC players row -->
			<div class="row-fluid" style="height:40px; margin-bottom:10px;">
				<!-- MC Online Players -->
				<div id="mc_players" class="span6 offset3"></div>
			</div>
			<!-- Twitter row -->
			<div class="row-fluid">
				<!-- Twitter feed -->
				<div class="span6 offset3" style="margin-top:30px;">
				<h3>Status Feed</h3>
				<a class="twitter-timeline" data-chrome="noheader nofooter transparent noscrollbar" data-dnt="true" href="https://twitter.com/d4rk_co" data-widget-id="355225493391437824">Tweets by @d4rk_co</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
			</div>
		</div>
		<!-- FTB Modal -->
		<div id="ftbModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">FTB Server Info</h3>
			</div>
			<div class="modal-body clearfix">
					<ul class="inline">
					<li><h4>Address:</h4></li>
					<li><code>ftb.d4rk.co</code></li>
					</ul>
					<h4>Feed the Beast</h4>
					<a href="http://feed-the-beast.com/#download_wrapper" class="btn btn-primary">Download FTB</a>
					<a href="https://minecraft.net/store" class="btn">Buy Minecraft</a>
					<h4>Install Tutorials</h4>
					<a href="http://youtu.be/J_UlF6IjOp8" class="btn btn-info"><i class="icon-youtube-play"></i> Mac</a>
					<a href="http://youtu.be/hdSSYws9uvk" class="btn btn-info"><i class="icon-youtube-play"></i> PC</a>

			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
		<!-- MC Modal -->
		<div id="mcModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Minecraft Server Info</h3>
			</div>
			<div class="modal-body clearfix">
					<ul class="inline">
					<li><h4>Address:</h4></li>
					<li><code>mc.d4rk.co</code></li>
					</ul>
					<h4>Minecraft</h4>
					<a href="https://minecraft.net/download" class="btn btn-primary">Download</a>
					<a href="https://minecraft.net/store" class="btn">Buy</a>
					<h4>Beginner Tutorials</h4>
					<a href="http://youtu.be/B36Ehzf2cxE" class="btn btn-info"><i class="icon-youtube-play"></i> YouTube</a>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
	</body>
</html>