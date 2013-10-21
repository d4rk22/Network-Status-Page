<?php
class link
{
	public $name;
	public $url;
	public $ico;
	public $prefix;
	
	function __construct($name, $url, $ico, $prefix = "target=\"_blank\"")
	{
		$this->name = $name;
		$this->url = $url;
		$this->ico = $ico;
		$this->prefix = $prefix;
	}
	
	function makeLink()
	{
		echo "<li><a href=\"$this->url\" $this->prefix><i class=\"icon-fixed-width icon-$this->ico\"/></i> $this->name</a></li>";
	}
}
?>