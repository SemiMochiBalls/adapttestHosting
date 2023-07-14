<?php
require_once("Model/User.php");
session_start();
date_default_timezone_set("Asia/Manila");
$Connection = new Connection();
$con = $Connection->buildConnection();
$deletepatient = $_POST['patient_id'];
?>
<html>
<?php 
include("Controller/header.php");
?>
<body>
<?php
include("Controller/nav.php");
?>

<div class="container" style="margin-top: 5%; width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalTitle">Are you sure?</h5>
        <button type="button" class="closebutton" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <p>You are about to delete a patient, do you wish to continue?</p>
      </div>
      <div class="modal-footer">
      <form action="Controller/deletepatient.php" method="POST">
            <input type="hidden" name="patient_id" id="patient_id" value="<?= $deletepatient?>">
            <input type="submit" value="Yes" class="btn btn-secondary"></input>
      </form>
      <form action="manage.php" method="POST">
            <input type="submit" value="No" class="btn btn-danger"></input>
      </form>
      </div>	
    </div>
</div>
<?php include("Controller/script.php")?>
</body>
</html>