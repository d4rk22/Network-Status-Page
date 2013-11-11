<?php
include 'init.php';
include ROOT_DIR . '/assets/php/functions.php';
$image_url = $_GET['img'];
$network = getNetwork();
$plexAddress = $network.':'.$plex_port;
$addressPosition = strpos($image_url, $plexAddress);
if($addressPosition !== false && $addressPosition == 0) {
	$image_src = $image_url . '?X-Plex-Token=' . $plexToken;
	header('Content-type: image/jpeg');
	//header("Content-Length: " . filesize($image_src));
	readfile($image_src);
} else {
echo "Bad Plex Image Url";	
}
?>