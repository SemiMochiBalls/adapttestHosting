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
if(isset($_SESSION['verifymsg'])){
	$error = $_SESSION['verifymsg'];
	unset($_SESSION['verifymsg']);
}
if(isset($error)){
?>
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="sucessModalHeader" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalTitle">Error</h5>
        <button type="button" class="closebutton" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p><?=$error?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary closebutton" data-dismiss="modal">Close</button>
      </div>	
    </div>
  </div>
</div>
<?php
}
include("Controller/nav.php");
?>
    <div class="container" style="margin-top: 35px; border: 1px solid; border-color: #E1E1E1; padding: 30px; width: 500px; background: white;">
        <form action="Controller/forgotpassword.php" method="POST" autocomplete="off">
        <h3>Forgot Password</h3>
        <p>Enter username</p>
        <hr>
        <div class="form-group">
        <?php
        $errors= [];
            if ($errors > 0) {
                foreach ($errors as $displayErrors) {
            ?>
                    <div id="alert"><?php echo $displayErrors; ?></div>
            <?php
                }
            }
            ?>
            <label for="username">Username: </label>
            <input type="text" class="form-control" name="usercheck" id="usercheck" placeholder="Enter Username">
        </div>
            <div class="row">
                <div class="col-3">
                    <input type="submit" class="btn btn-success" value="Check">
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