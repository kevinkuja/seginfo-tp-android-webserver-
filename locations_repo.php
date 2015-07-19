<?php
class Location{ 
	private $data = Array(
		'retrieved_date' => null,
		'remote_addr' => null,
		'user_agent' => null,
		'location' => Array(
			'lat' => null,
			'lng' => null
			)
		); 

	public function Location($array_data){
		$this->data = array_merge($this->data, $array_data);
	}

	public static function from_json($data_json){
		return new Location(json_decode($data_json, true));
	}

	public function getRetrievedDate(){ return new DateTime($this->data['retrieved_date']); }
	public function getRemoteAddr(){ return $this->data['remote_addr']; }
	public function getUserAgent(){ return $this->data['user_agent']; }
	public function getLocation(){ return $this->data['location']['lat'].", ".$this->data['location']['lng']; }
}

class LocationsRepository{
	private static $instance;
	private $file_name = "locations.txt";
	private $file_ptr;

	private function open_file($mode){
		if( !file_exists($this->file_name) )
			throw new Exception('No existe el archivo '.$this->file_name);

		if( $mode == 'w' and !is_writable($this->file_name) )
			throw new Exception('No se puede escribir en archivo '.$this->file_name);

		if( !($this->file_ptr = fopen($this->file_name, $mode)) )
			throw new Exception('No se puede abrir el archivo '.$this->file_name);
	}

	private function close_file(){
		if( $this->file_ptr )
			fclose($this->file_ptr);
	}

	public static function getInstance()
	{
		if ( !self::$instance instanceof self )
		{
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function getLocations(){
		$locations = [];

		$this->open_file('r');
		while( $location_json = fgets( $this->file_ptr ) ){
			$locations[] = Location::from_json($location_json);
		}
		$this->close_file();

		return array_reverse($locations);
	}

	public function getTotalCount(){
		$locations = 0; 

		$this->open_file('r');
		while( $location_json = fgets( $this->file_ptr ) )
			$locations++;
		$this->close_file();

		return $locations;
	}

	public function addLocation($lat, $lng){
		$this->open_file('a');

		$location_array = Array(
			'retrieved_date' => date("c"),
			'remote_addr' => $_SERVER['REMOTE_ADDR'],
			'user_agent' => $_SERVER['HTTP_USER_AGENT'],
			'location' => Array(
				'lat' => $lat,
				'lng' => $lng
				)
		);

		fwrite( $this->file_ptr, json_encode($location_array). PHP_EOL );
		
		$this->close_file();
	}

	public function reset(){
		$this->open_file('w');
		fwrite( $this->file_ptr, "" );
		$this->close_file();
	}
}
?>