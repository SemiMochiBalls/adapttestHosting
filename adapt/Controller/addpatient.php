<?php
session_start();
require_once("../Model/Connection.php");
include("log.php");
$Connection = new Connection();
$con = $Connection->buildConnection();
// fname lnmae bday desc
function repeatEncode($num, $string){
    $num %= 7;
    for($i = $num + 2 ; $i > 0 ; $i--){
        $string = base64_encode($string);
    }
    return $string;
}
$firstname = base64_encode($_POST['firstname']);
$lastname = base64_encode($_POST['lastname']);
$bday = $_POST['birthday'];
$desc = $_POST['desc'];
$address = $_POST['address'];
$city = $_POST['city'];
$province = $_POST['province'];
$postalcode = $_POST['postalcode'];
$country = $_POST['country'];
$maxdistance = $_POST['maxdistance'];


$mpStatement = $con->prepare("INSERT INTO patients(patient_fname, patient_lname, patient_bday, patient_desc, patient_address, patient_city, patient_province, patient_postalcode, patient_country, patient_maxdistance,patient_user) VALUES (?,?,?,?,?,?,?,?,?,?)");
$mpStatement->bind_param("sssssssisid", $firstname, $lastname, $bday, $desc, $address, $city, $province, $postalcode, $country, $maxdistance);
$mpStatement->execute();
$mpStatement->close();  
$patientprint = $con->query("SELECT * FROM patients ORDER BY patient_id DESC LIMIT 1");
$num = $patientprint->fetch_assoc()['patient_id'];

$mpStatement = $con->prepare("UPDATE patients SET patient_fname = ?, patient_lname = ? WHERE patient_id = $num");
$mpStatement->bind_param("ss",repeatEncode($num, $firstname),repeatEncode($num, $lastname));
$mpStatement->execute();
$mpStatement->close();


$_SESSION['success'] = "Patient Added";
$_SESSION['successmsg'] = "Patient has been successfully added to the patient database.";
header("location:../manage.php");

