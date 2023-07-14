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
    <div class="container" style="margin-top: 35px; border: 1px solid; border-color: #E1E1E1; padding: 30px; width: 500px; background: white;">
        <form action="Controller/login.php" method="POST">
        <h3>Password</h3>
        <p>Enter new password</p>
        <hr>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            <label for="password">Confirm Password:</label>
            <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirm Password" required>
        </div>
            <div class="row">
                <div class="col-3">
                    <input type="submit" class="btn btn-success" name="changePassword" value="Save">
                </div>
            </div>
        </form>	
    </div>
    <?php include("Controller/script.php")?>
<script>
  $(document).ready(function(){
    $("#successModal").modal('show');
    const closeButtons = document.querySelectorAll(".closebutton");
    // close of modal
    closeButtons.forEach(function (closeButton) {
      closeButton.addEventListener("click", function() {
        $("#successModal").modal('hide');
      });
    });
  });
</script>
</body>
</html>