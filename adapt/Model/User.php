<?php
require_once("Connection.php");
	class User{
		public $id;
		public $username;
		private $password;
		public $email;
		public $firstname;
		public $lastname;

		function __construct($id){
			$Connection = new Connection();
			$con = $Connection->buildConnection();
			$result = $con->query("SELECT * FROM user_data WHERE id = $id");
			$fetch = $result->fetch_assoc();
			$this->id = $fetch['user_id'];
			$this->username = $fetch['username'];
			$this->password = $fetch['password'];
			$this->email = $fetch['email'];
			$this->firstname = $fetch['firstname'];
			$this->lastname = $fetch['lastname'];
			$con->close();
		}

		function refresh(){
			$Connection = new Connection();
			$con = $Connection->buildConnection();
			$id = $this->id;
			$con->query("SELECT * FROM user_data WHERE user_id = $id");
			$fetch = $con->fetch_assoc();
			$this->id = $fetch['user_id'];
			$this->username = $fetch['username'];
			$this->password = $fetch['password'];
			$this->email = $fetch['email'];
			$this->firstname = $fetch['firstname'];
			$this->lastname = $fetch['lastname'];
			$con->close();
		}
	}
?>