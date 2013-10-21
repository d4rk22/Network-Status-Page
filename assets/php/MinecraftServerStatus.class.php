<?php
/**
 * Minecraft server status class
 * Query minecraft server
 * @author    Patrick K. - http://www.silexboard.org/ - https://github.com/NoxNebula
 * @license   GNU Public Licence - Version 3
 * @copyright © 2011-2013 Patrick K.
 */
class MinecraftServerStatus {
	// Get the server status
	const STATUS    = 0x00;
	// Make the challenge (handshake)
	const HANDSHAKE = 0x09;

	// "Magic bytes"
	const B1 = 0xFE;
	const B2 = 0xFD;

	private $Socket;

	// Expected server info (Minecraft 1.3.2)
	// more keys may added while running the code
	private $Info = [
		'hostname'   => '',
		'gametype'   => '',
		'game_id'    => '',
		'version'    => '',
		'plugins'    => '',
		'map'        => '',
		'numplayers' => '',
		'maxplayers' => '',
		'hostport'   => '',
		'hostip'     => ''
	];

	/**
	 * Query a minecraft server and parse the status
	 * @param string $Host
	 * @param int    $Port    optional
	 * @param int    $Timeout optional
	 */
	public function __construct($Host, $Port = 25565, $Timeout = 1) {
	/* Connect to the host and creat a socket */
		$this->Socket = @stream_socket_client('udp://'.$Host.':'.(int)$Port, $ErrNo, $ErrStr, $Timeout);
		if($ErrNo || $this->Socket === false) {
			$this->Info['online'] = false; return;
			//throw new Exception('Failed to connect', 1);
		}
		stream_set_timeout($this->Socket, $Timeout);

	/* Make handshake and request server status */
		$Data = $this->Send(self::STATUS, pack('N', $this->Send(self::HANDSHAKE)).pack('c*', 0x00, 0x00, 0x00, 0x00));
		//set_time_limit($met);

		// Try fallback if query is not enabled on the server
		if(!$Data){
			if(!class_exists('MinecraftServerStatusSimple') && file_exists('MinecraftServerStatusSimple.class.php'))
				require_once('MinecraftServerStatusSimple.class.php');
			if(class_exists('MinecraftServerStatusSimple')) {
				$Fallback = new MinecraftServerStatusSimple($Host, $Port, $Timeout);
				$this->Info = [
					'hostname'   => $Fallback->Get('motd'),
					'numplayers' => $Fallback->Get('numplayers'),
					'maxplayers' => $Fallback->Get('maxplayers'),
					'hostport'   => (int)$Port,
					'hostip'     => $Host,
					'online'     => $Fallback->Get('online')
				]; fclose($this->Socket); return;
			}
		}

	/* Prepare the data for parsing */
		// Split the data string on the player position
		$Data = explode("\00\00\01player_\00\00", $Data);
		// Save the players
		$Players = '';
		if($Data[1])
			$Players = substr($Data[1], 0, -2);
		// Split the server infos (status)
		$Data = explode("\x00", $Data[0]);

	/* Parse server info */
		for($i = 0; $i < sizeof($Data); $i += 2) {
			// Check if the server info is expected, if yes save the value
			if(array_key_exists($Data[$i], $this->Info) && array_key_exists($i+1, $Data))
				$this->Info[$Data[$i]] = $Data[$i+1];
		}

		// Parse plugins and try to determine the server software
		if($this->Info['plugins']) {
			$Data = explode(": ", $this->Info['plugins']);
			$this->Info['software'] = $Data[0];
			if(isset($Data[1]))
				$this->Info['plugins']  = explode('; ', $Data[1]);
			else
				unset($this->Info['plugins']);
		} else {
			// It seems to be a vanilla server
			$this->Info['software'] = 'Vanilla';
			unset($this->Info['plugins']);
		}

		// Parse players
		if($Players)
			$this->Info['players'] = explode("\00", $Players);

		// Cast types
		$this->Info['numplayers'] = (int)$this->Info['numplayers'];
		$this->Info['maxplayers'] = (int)$this->Info['maxplayers'];
		$this->Info['hostport']   = (int)$this->Info['hostport'];

		$this->Info['online'] = true;
	/* Close the connection */
		fclose($this->Socket);
	}

	/**
	 * Return the value of an key or the whole server info
	 * @param  string $Key optional
	 * @return mixed
	 */
	public function Get($Key = '') {
		return $Key ? (array_key_exists($Key, $this->Info) ? $this->Info[$Key] : false) : $this->Info;
	}

	/**
	 * Send a command to the server and get the answer
	 * @param  byte $Command
	 * @param  byte $Addition optional
	 * @return string
	 */
	private function Send($Command, $Addition = '') {
		// pack the command into a binary string
		$Command = pack('c*', self::B1, self::B2, $Command, 0x01, 0x02, 0x03, 0x04).$Addition;
		// send the binary string to the server
		if(strlen($Command) !== @fwrite($this->Socket, $Command, strlen($Command)))
			// my attempt to not throw exceptions
			return false;
			#throw new Exception('Failed to write on socket', 2);

		// listen what the server has to say now
		$Data = fread($this->Socket, 2048);
		if($Data === false)
			// my attempt to not throw exceptions
			return false;
			#throw new Exception('Failed to read from socket', 3);

		// remove the first 5 unnecessary bytes (0x00, 0x01, 0x02, 0x03, 0x04) Status type and own ID token
		return substr($Data, 5);
	}
}

#catch (Exception $e)
	{
	//do nothing
	}
