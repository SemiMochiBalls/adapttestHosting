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
<?php
if(isset($_SESSION['errors'])){
	$errors = $_SESSION['errors'];
	unset($_SESSION['errors']);
}
if(isset($_SESSION['success'])){
	$success = $_SESSION['success'];
	unset($_SESSION['success']);
}
if(isset($errors) || isset($success)){
?>
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="sucessModalHeader" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalTitle"><?php if(!empty($success)){echo "Successfully Signed Up";}else if(!empty($errors)){echo "Login Failed";} ?></h5>
        <button type="button" class="closebutton" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<?php
		if(!empty($errors))
		foreach ($errors as $key => $value) {
		?>
		<li><?= $value ?></li>
		<?php
		}
		if(!empty($success))
		foreach ($success as $key => $value) {
		?>
		<li><?= $value ?></li>
		<?php
		}
		?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary closebutton" data-dismiss="modal">Close</button>
      </div>	
    </div>
  </div>
</div>
<?php
}
?>
<div class="container" style="margin-top: 35px; border: 1px solid; border-color: #E1E1E1; padding: 30px; width: 500px; background: white;">
	<form action="Controller/login.php" method="POST">
	<h3>Login</h3>
	<p>Enter username and password to log in</p>
	<hr>
	  <div class="form-group">
	    <label for="username">Username:</label>
	    <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username">
	  </div>
	  <div class="form-group">
	    <label for="password">Password: </label>
	    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
	  </div>
	  	<div class="row">
	  		<div class="col-3">
	  			<input type="submit" class="btn btn-success" value="Login">
	  		</div>
	  		<div class="col-9 mt-1">
				<i>Forgot your password? </i>
				<a href="forgot.php">Change it here</a>
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