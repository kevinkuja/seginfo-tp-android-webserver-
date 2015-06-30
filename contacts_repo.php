<?php
class Contact{
	private $data = Array(
		'id' => null,
		'name' => null, 
		'phones' => Array() /* Array de String */
	);

	public function __construct($array_data){ $this->data = array_merge( $this->data, $array_data ); }

	public function getID(){ return $this->data['id']; }
	public function getName(){ return $this->data['name']; }
	public function getPhones(){ return $this->data['phones']; }
	public function getPhonesStringified(){ return json_encode($this->data['phones']); }
	public function toJSON(){ return json_encode($this->data); }
}

class PhoneBook{
	private $data = Array(
		'retrieved_date' => null,
		'remote_addr' => null,
		'user_agent' => null,
		'contacts' => Array() /* Array de Contact */
	);

	public function __construct($array_data){ 
		$this->data = array_merge($this->data, $array_data); 
	}

	public static function from_array($array_data){ return new PhoneBook($array_data); }
	public static function from_json($json){ 
		$data = json_decode($json, true);
		$contacts = $data['contacts'];

		$data['contacts'] = [];
		foreach($contacts as $contact){
			$data['contacts'][] = new Contact($contact);
		}

		return PhoneBook::from_array($data); 
	}
	
	public function getRetrievedDate(){ return new DateTime($this->data['retrieved_date']); }
	public function getRemoteAddr(){ return $this->data['remote_addr']; }
	public function getUserAgent(){ return $this->data['user_agent']; }
	public function getContacts(){ return $this->data['contacts']; }
}

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

	public function getPhoneBooks(){
		$phone_books = [];

		$this->open_file('r');
		while( $phone_book_json = fgets( $this->file_ptr ) ){
			$phone_books[] = PhoneBook::from_json($phone_book_json);
		}
		$this->close_file();

		return array_reverse($phone_books);
	}

	public function addContacts($contacts_json){

		$contacts = [];
		
		foreach(json_decode($contacts_json) as $contact_array){
			$contacts[] = new Contact($contact_array);
		}

		$phone_book = PhoneBook::from_array(Array(
			'retrieved_date' => date("c"),
			'remote_addr' => $_SERVER['REMOTE_ADDR'],
			'user_agent' => $_SERVER['HTTP_USER_AGENT'],
			'contacts' => $contacts
		));

		$this->open_file('a');
		fwrite( $this->file_ptr, $contacts->toJSON().'\n' );
		$this->close_file();
	}
}
?>