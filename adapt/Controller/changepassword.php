<?php
if (isset($_POST['changePassword'])){
    $Connection = new Connection();
    $con = $Connection->buildConnection();
    $password = md5($_POST['password']);
    $password2 = md5($_POST['confirmPassword']);

    if (strlen(trim($password)) < 8){
        $errors['password'] != 'Use 8 or more characters with a mix of letters, numbers, or symbols';
    } else{
        if ($password != $password2){
            $errors['password'] = 'Passwords do not match';
        } else{
            $password = md5($_POST['password']);
            $email = $_SESSION['email'];
            $code = 0;
            $updatePassword = "UPDATE [profile] SET password = '$password' WHERE email = '$email'";
            $updatePass = mysqli_query($con, $updatePassword) or die("Query Failed");
            session_unset($email);
            session_destroy();
            header('location: login.php');
        }
    }
}