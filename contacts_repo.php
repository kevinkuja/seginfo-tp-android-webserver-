<?php
class ContactsRepository{
	private static $instance;
	private $file_name = "contacts.txt";
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

	public function getContacts(){
		$this->open_file('r');

		if( filesize($this->file_name) == 0 )
			$contacts = "";
		else {
			$contacts = fread( $this->file_ptr, filesize($this->file_name) );	
		}
		$this->close_file();

		return $contacts;
	}

	public function addContacts($contacts){
		$this->open_file('a');

		$contacts_array = Array(
			'retrieved_date' => date("c"),
			'remote_addr' => $_SERVER['REMOTE_ADDR'],
			'user_agent' => $_SERVER['HTTP_USER_AGENT'],
			'contacts' => json_decode($contacts, true)
		);

		fwrite( $this->file_ptr, json_encode($contacts_array) );
		
		$this->close_file();
	}
}
?>