<?php
class ContactsRepository{
	private static $instance;
	private $file_name = "contacts.txt";
	private $file_ptr;

	private function open_file($mode){
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
		$contacts = fread( $this->file_ptr, filesize($this->file_name) );
		$this->close_file();

		return $contacts;
	}

	public function addContacts($contacts){
		$this->open_file('a');
		fwrite( $this->file_ptr, $contacts);
		$this->close_file();
	}
}
?>