<!DOCTYPE html>
<html lang="en">
<?php
require_once('MinecraftServerStatus.class.php');
$Server_FTB = new MinecraftServerStatus('127.0.0.1',25565); ?>
<!-- FTB Online check -->
<?php if($Server_FTB->Get('online')): ?>
	<!-- MOTD -->
	<button class="btn btn-info disabled"></i><?php echo $Server_FTB->Get('hostname'); ?></button>
<?php endif; ?>
<!-- FTB Online check -->
<?php if($Server_FTB->Get('online')): ?>
	<button class="btn btn-success disabled"><i class="icon-ok icon-white"></i> Online</button>
<?php else: ?>
	<button class="btn btn-danger disabled"><i class="icon-remove icon-white"></i> Offline</button>
<?php endif; ?>