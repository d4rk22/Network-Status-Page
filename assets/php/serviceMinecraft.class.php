<?php
class serviceMinecraft
{
	public $name;
	public $port;
	public $url;
	public $host;
	public $status;
	
	function __construct($name, $port, $url = "", $host = "localhost")
	{
		$this->name = $name;
		$this->port = $port;
		$this->url = $url;
		$this->host = $host;
		
		$this->status = $this->check_port();
	}
	
	function check_port()
	{
		$conn = @fsockopen($this->host, $this->port, $errno, $errstr, 0.5);
		if ($conn) 
		{
			fclose($conn);
			return true;
		}
		else
			return false;
	}
	
	function makeButton()
	{
		$server = getMinecraftPlayers($this->port);
		$numPlayers = $server[1];
		$players = 'Player';
		if($numPlayers > 1) {
			$players = 'Players';
		}
		if ($server[0] == true):
			$icon = ' ';//'<i class="icon-' . ($this->status ? 'user' : 'remove') . ' icon-white"></i>';
			$txt = $this->status ? $numPlayers.' '.$players : 'Offline';
		else:
			$icon = '<i class="icon-' . ($this->status ? 'ok' : 'remove') . ' icon-white"></i>';
			$txt = $this->status ? 'Online' : 'Offline';
		endif;
		$btn = $this->status ? 'success' : 'warning';
		$prefix = $this->url == "" ? '<button style="width:62px" class="btn btn-xs btn-' . $btn . ' disabled">' : '<a href="' . $this->url . '" style="width:62px" class="btn btn-xs btn-' . $btn . '">';
		$suffix = $this->url == "" ? '</button>' : '</a>';
		
		return $prefix . $icon . " " . $txt . $suffix;
	}
}
?>