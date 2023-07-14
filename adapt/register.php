<?php
require_once("Model/User.php");
session_start();
include("Controller/log.php");
if(isset($_SESSION['user'])){
	header("location:index.php");
}
?>
<html>
<?php 
include("Controller/header.php");
?>
<body style="margin: auto;">
<?php
include("Controller/nav.php");
if(isset($_SESSION['errors'])){
	$errors = $_SESSION['errors'];
	unset($_SESSION['errors']);
}
if(isset($errors)){
?>
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="sucessModalHeader" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalTitle">Sign up Failed</h5>
        <button type="button" class="closebutton" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <?php
		foreach ($errors as $key => $value) {
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
		<form action="Controller/register.php" onsubmit="formSubmit(event)" id="signupForm" method="POST">
		<h2>Sign Up</h3>
		<p>Fill in the form below to get instant access</p>
		<hr>
		  <div class="form-group">
		  	<div class="row">
		  		<div class="col">
		  			<label for="firstname">Firstname:</label>
		  			<input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter First Name" required>
					<small style="color:red" id="fnameError"></small>
		  		</div>
		  		<div class="col">
		  			<label for="lastname">Lastname:</label>
		  			<input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter Last Name" required>
					<small style="color:red" id="lnameError"></small>
		  		</div>
		  	</div>
		  </div>
		  <div class="form-group">
		    <label for="username">Username:</label>
		    <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" required>
			<small style="color:red" id="unameError"></small>
		  </div>
		  <div class="form-group">
		  	<label for="email">Email:</label>
		  	<input type="text" class="form-control" name="email" id="email"
		  	placeholder="Enter Email" required>
		  </div>
		  <div class="form-group">
		    <label for="password">Password: </label>
		    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
		  </div>
		  <div class="form-group">
		    <label for="password2">Re-Enter Password: </label>
		    <input type="password" name="password2" class="form-control" id="password2" placeholder="Enter Password" required>
		  </div>
			<div class="row">
				<div class="col-4" style="text-align:center;">
					<input type="submit" class="btn btn-success" value="Register">
				</div>
				<div class="col-8 mt-1">
					<i>Already have an account? </i>
					<a href="login.php">Log in here</a>
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
  function formSubmit(e) {
    const fname = $("#firstname").val()
    const lname = $("#lastname").val()
	const uname = $("#username").val()
    const errors = {}
    if(!validator.isAlpha(fname, 'en-US', {ignore: " -"}) || validator.isEmpty(fname.replaceAll(" ", ""))){
      errors.fname = "First name is invalid!"
    }
    else{
      delete errors.fname
    }
    if(!validator.isAlpha(lname, 'en-US' ,{ignore: " -"}) || validator.isEmpty(lname.replaceAll(" ", ""))){
      errors.lname = "Last name is invalid!"
    }
    else{
      delete errors.lname
    }
	if(validator.isEmpty(uname.replaceAll(" ", ""))){
      errors.uname = "Username is invalid!"
    }
    else{
      delete errors.uname
    }
    console.log(errors)
    $("#fnameError").text(errors?.fname?errors.fname : "")
    $("#lnameError").text(errors?.lname?errors.lname : "")
    $("#unameError").text(errors?.uname?errors.uname : "")
    if(Object.keys(errors).length === 0){
      // No ERRORS do what you have to do
      $("#signupForm").submit()
    }
    else{
      e.preventDefault()
    }
  }
</script>
</body>
</html>