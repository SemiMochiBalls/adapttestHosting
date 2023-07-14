<?php
session_start();
require_once("../Model/User.php");
include("log.php");
$Connection = new Connection();
$con = $Connection->buildConnection();
$username = $_POST['username'];
$password = $_POST['password'];

$guStatement = $con->prepare("SELECT * FROM users WHERE username LIKE ?"); 
$guStatement->bind_param("s", $username);
$guStatement->execute();
$result = $guStatement->get_result();
if($User = $result->fetch_assoc()){
	//$User  =  {id, username, password};
	if(password_verify($password, $User['password'])){
		$User = new User($User['id']);
		//$User = Model
		$_SESSION['userlogged'] = $_POST['username'];
		$_SESSION['user'] = $User;
		header("location:../");
		if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $log = "Username: " . $username . " logged in";

            logger($log);
		}
		else{
		    echo "Login attempt by user, ".$username;
		}
	}else{
		$_SESSION['errors'] = array("Wrong password.");
		header("location:../login.php");
		if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $log = "Username: " . $username . " tried to log in";

            logger($log);
		}
	}
}
else{
		$_SESSION['errors'] = array("User not found.");
		header("location:../login.php");
}

?>