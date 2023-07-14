<?php
session_start();
require_once("../Model/Connection.php");
include("log.php");

$Connection = new Connection();
$con = $Connection->buildConnection();
$patient_id = $_POST['patient_id'];
$dpStatement = $con->prepare("DELETE FROM patients WHERE patient_id=?");
$dpStatement->bind_param("i", $patient_id);
$dpStatement->execute();
$dpStatement->close();

$_SESSION['success'] = "Patient Deleted";
$_SESSION['successmsg'] = "Patient has been successfully deleted on the patient database.";
header("location:../manage.php");