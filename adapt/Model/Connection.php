<?php
class Connection{
	private $host;
	private $username;
	private $password; 
	private $dbname;

	public function __construct(){
		$this->host = "localhost:3306";
		$this->username = "root";
		$this->password = "";
		$this->dbname = "adapt";
	}

	public function buildConnection(){
		return new mysqli($this->host, $this->username, $this->password, $this->dbname);
	}
}
?>