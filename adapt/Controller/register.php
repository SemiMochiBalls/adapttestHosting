<?php
session_start();
require_once("../Model/Connection.php");
include("log.php");
$Connection = new Connection();
$con = $Connection->buildConnection();
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$email = $_POST['email'];
$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];
$password2 = $_POST['password2'];

$errors = array("Password doesn't match.", "First name is a must.", "Last name is a must.", "Invalid Email", "Username already exists", "Password too short", "Password too long");

if(
	isset($firstname) && 
	isset($lastname) && 
	isset($username) && 
	isset($email) &&
	isset($password) && 
	isset($password2)
){
	$errorCollector = array();
	if($password != $password2)
		array_push($errorCollector, $errors[0]);
	if(empty($firstname))
		array_push($errorCollector, $errors[1]);
	if(empty($lastname))
		array_push($errorCollector, $errors[2]);
	if (filter_var($emailB, FILTER_VALIDATE_EMAIL) === false || $emailB != $email)array_push($errorCollector, $errors[3]);

	$suStatement = $con->prepare("SELECT * FROM users WHERE username LIKE ?");
	$suStatement->bind_param("s",$username);
	$suStatement->execute();
	$user = $suStatement->get_result();
	if($userRow = $user->fetch_assoc())
		array_push($errorCollector, $errors[4]);
	if(strlen($password)<5)
		array_push($errorCollector, $errors[5]);
	if(strlen($password)>16)
		array_push($errorCollector, $errors[6]);
	if(count($errorCollector) == 0){
		$hashPassword = password_hash($password, PASSWORD_DEFAULT);
		$iuStatement = $con->prepare("INSERT INTO users(username,password) VALUES (?,?)");
		$iuStatement->bind_param("ss", $username, $hashPassword);
		$iuStatement->execute();
		$suStatement->execute();
		$iuStatement->close();
		$user = $suStatement->get_result();
		$userRow = $user->fetch_assoc();
		$suStatement->close();
		$userid = $userRow['id'];
		$ipStatement = $con->prepare("INSERT INTO profile(firstname,lastname,email,user_id) VALUES (?,?,?,?)");
		$ipStatement->bind_param("sssi",$firstname,$lastname,$email,$userid);
		print_r($con->errors);
		$ipStatement->execute();
		$ipStatement->close();
		$_SESSION['success'] = array("Account Registered");
		if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $log = "Username: " . $username . " registered";

            logger($log);
		}  
		header("location:../login.php");
	}
	else{
		$_SESSION['errors'] = $errorCollector;
		header("location:../register.php");
	}
}
else{
	header("location:../register.php");
}
?>