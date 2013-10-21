<!DOCTYPE html>
<html lang="en">
<?php
require_once('MinecraftServerStatus.class.php');
$Server_MC = new MinecraftServerStatus('127.0.0.1',25564); ?>
<!-- MC Online check -->
<?php if($Server_MC->Get('online')): ?>
	<!-- MOTD -->
	<button class="btn btn-info disabled"></i> <?php echo $Server_MC->Get('hostname'); ?></button>
<?php endif; ?>
<!-- MC Online check -->
<?php if($Server_MC->Get('online')): ?>
	<button class="btn btn-success disabled"><i class="icon-ok icon-white"></i> Online</button>
<?php else: ?>
	<button class="btn btn-danger disabled"><i class="icon-remove icon-white"></i> Offline</button>
<?php endif; ?>