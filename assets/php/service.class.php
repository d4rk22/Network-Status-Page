<?php
class service
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
		$icon = '<i class="icon-' . ($this->status ? 'ok' : 'remove') . ' icon-white"></i>';
		$btn = $this->status ? 'success' : 'warning';
		$prefix = $this->url == "" ? '<button style="width:62px" class="btn btn-xs btn-' . $btn . ' disabled">' : '<a href="' . $this->url . '" style="width:62px" class="btn btn-xs btn-' . $btn . '">';
		$txt = $this->status ? 'Online' : 'Offline';
		$suffix = $this->url == "" ? '</button>' : '</a>';
		
		return $prefix . $icon . " " . $txt . $suffix;
	}
}
?>