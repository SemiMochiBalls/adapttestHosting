<?php
require_once("Model/User.php");
session_start();
?>
<html>
<?php 
include("Controller/header.php");
?>
<body style="margin: auto;">
<?php
include("Controller/nav.php");
?>	
<body>
    <div id="container">
        <h2>Email</h2>
        <p>Please enter the verification code.</p>
        <div id="line"></div>
        <form action="verifyEmail.php" method="POST" autocomplete="off">
            <?php
            if(isset($_SESSION['message'])){
                ?>
                <div id="alert"><?php echo $_SESSION['message']; ?></div>
                <?php
            }
            ?>

            <?php
            $errors = [];
            if($errors > 0){
                foreach($errors AS $displayErrors){
                ?>
                <div id="alert"><?php echo $displayErrors; ?></div>
                <?php
                }
            }
            ?>      
            <input type="number" name="OTPverify" placeholder="Verification Code" required><br>
            <input type="submit" name="verifyEmail" value="Verify">
        </form>
    </div>
</body>