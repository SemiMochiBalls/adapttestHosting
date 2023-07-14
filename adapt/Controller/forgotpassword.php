<?php
session_start();
require_once("../Model/Connection.php");
include("log.php");
$Connection = new Connection();
$con = $Connection->buildConnection();
$usernamecheck = $con->query("SELECT * FROM users");
$correct = 0;
if(isset($_POST['usercheck'])){
    $userinput = $_POST['usercheck'];
    while($fetch = $usernamecheck->fetch_assoc()){
    if($userinput == $fetch['username']){
    $correct++;
    if($correct>0){
        $userid = $fetch['id'];
    }
    }else if($correct<1){
        $_SESSION['verifymsg'] = "The username entered is not found. ";
        header("location:../forgot.php");
    }
    }
}



// if( isset($_SESSION["userid"]) ){
//     $userid = $_SESSION["userid"];    
//     unset($_SESSION['userid']);
// }
// $useremail = $con->query("SELECT email FROM profile WHERE id = $userid");
// while($fetch =$useremail->fetch_assoc()){
//     $email = $fetch['email'];
// }

$emailCheckResult = $con->query("SELECT * FROM profile WHERE id = $userid");
//if query runs
    if($emailCheckResult){
        if(mysqli_num_rows($emailCheckResult) > 0){
 
            $code = rand(999999, 111111);
            $updateResult = $con->query("UPDATE profile SET code = $code WHERE id = $userid");
            // $updateQuery = "UPDATE [profile] SET code = $code WHERE email = '$email'";
            // $updateResult = mysqli_query($con, $updateQuery);
            if($updateResult){
                $subject = "Email Verification Code";
                $message = "Your verification code is $code";
                $sender = 'From: ma382793@gmail.com';

            if(mail($email, $subject, $message, $sender)){
                $message = "We've sent a verification code to your Email <br> $email";
                $SESSION['message'] = $message;
                header('location: verifyEmail.php');
            } else {
                $errors['otp_errors'] = 'Failed while sending code!';
            }
            } else {
                $errors['db_errors'] = "Failed while inserting data into database!";
        }
    } else{
        $errors['invalidEmail'] = "Invalid Email Address";
    }
}else {
    $errors['db_error'] = "Failed while checking email from database!";
}
header("location:../verifyEmail.php");
?>