<?php
require_once("Model/User.php");
session_start();
date_default_timezone_set("Asia/Manila");
$Connection = new Connection();
$con = $Connection->buildConnection();
$patientprint = $con->query("SELECT * FROM patients");
function repeatDecode($num, $string){
  $num %= 7;
  for($i = $num + 3 ; $i > 0 ; $i--){
      $string = base64_decode($string);
  }
  return $string;
}
?>
<html>
<?php 
include("Controller/header.php");
?>
<body>
<?php
if(isset($_SESSION['success'])){
	$success = $_SESSION['success'];
  $successmsg = $_SESSION['successmsg'];
	unset($_SESSION['success']);
}
if(isset($success)){
?>
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="sucessModalHeader" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalTitle"><?=$success?></h5>
        <button type="button" class="closebutton" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <p><?=$successmsg?></p>
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
<!-- title for table -->
<div class="container">
    <div class="row managetitle">
        <div class="col-5">
            <span>Your Patients</span>
        </div>
        <div class="col-7">
        </div>
    </div><hr style="height:2px; border-width:0; color:black; background-color:black;">
</div><br>
<!-- table for patients -->
<div class="container">
    <div class="row">
        <div class="col-3 m-auto">
            <span>First name</span>
        </div>
        <div class="col-3 m-auto">
            <span>Last Name</span>
        </div>
        <div class="col-2 m-auto">
            <span>Age</span>
        </div>
        <div class="col-4 m-auto" style="text-align: center;">
            <!-- modal button -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPatient">
             Add Patient
        </button>
        </div>
    </div><hr>
    <?php
      while($fetch = $patientprint->fetch_assoc()){
      ?>
    <div class="row"><hr>
        <div class="col-3 m-auto">
          <span><?= repeatDecode($fetch['patient_id'], $fetch['patient_fname'])?></span>
        </div>
        <div class="col-3 m-auto">
          <span><?= repeatDecode($fetch['patient_id'], $fetch['patient_lname'])?></span>
        </div>
        <div class="col-2 m-auto">
          <span><?= date_diff(date_create($fetch['patient_bday']), date_create())->format('%y')?></span>
        </div>
        <div class="col-4 m-auto" style="text-align: center;">
          <!-- modal button -->
          <form action="viewpatient.php" method="GET">
            <input type="hidden" name="patient_id" id="patient_id" value="<?= $fetch['patient_id']?>">
            <input type="submit" value="View Patient" class="btn btn-secondary"></input>
          </form>
        </div>
    </div><hr>
    <?php
      }
      ?>
</div>

<!-- Modal for Add Patient -->
<div class="modal fade" id="addPatient" tabindex="-1" role="dialog" aria-labelledby="addPatientHeader" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPatientTitle">Add patient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="Controller/addpatient.php" onsubmit="formSubmit(event)" id="patientForm" method="POST">
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
          <label for="birthday">Birthdate:</label>
          <input type="date" class="form-control" name="birthday" id="birthday" required>
          <small style="color:red" id="bdayError"></small>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" required>
            <small style="color:red" id="addressError"></small>
        </div>
        <div class="form-group">
            <label for="address">City:</label>
            <input type="text" class="form-control" name="city" id="city" placeholder="Enter City" required>
            <small style="color:red" id="cityError"></small>
        </div>
        <div class="form-group">
            <label for="address">Province:</label>
            <input type="text" class="form-control" name="province" id="province" placeholder="Enter Province" required>
            <small style="color:red" id="provinceError"></small>
        </div>
        <div class="form-group">
            <label for="address">Postal Code:</label>
            <input type="text" class="form-control" name="postalcode" id="postalcode" placeholder="Enter Postal Code" required>
            <small style="color:red" id="postalcodeError"></small>
        </div>
        <div class="form-group">
            <label for="address">Country:</label>
            <input type="text" class="form-control" name="country" id="country" placeholder="Enter Country" required>
            <small style="color:red" id="countryError"></small>
        </div>
        <div class="form-group">
          <label for="maxdistance">Set Max Distance before Out of Bounds (In Meters):</label>
          <input type="text" class="form-control" name="maxdistance" id="maxdistance" placeholder="Enter Max Distance" required>
          <small style="color:red" id="maxdistanceError"></small>
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea class="form-control" name="desc" id="desc" placeholder="Enter Description" rows="4" required></textarea>
          <small style="color:red" id="descError"></small>
        </div>
        <br/>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>	
    </div>
  </div>
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
    const bday = $("#birthday").val()
    const desc = $("#desc").val()
    const address = $("#address").val()
    const city = $("#city").val()
    const province = $("#province").val()
    const postalcode = $("#postalcode").val()
    const country = $("#country").val()
    const maxdistance = $("#maxdistance").val()

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

    if(!validator.isDate(bday) || (validator.isAfter(bday, new Date().toString()) && bday !== dayjs().format("YYYY-MM-DD"))){
      errors.bday = "Invalid birth date!"
    }
    else{
      delete errors.bday
    }

    if(validator.isEmpty(desc.replaceAll(" ", ''))){
      errors.desc = "Description must not be empty!"
    }
    else{
      delete errors.desc
    }

    if(validator.isEmpty(address.replaceAll(" ", ''))){
      errors.desc = "Address must not be empty!"
    }
    else{
      delete errors.address
    }

    if(validator.isEmpty(city.replaceAll(" ", ''))){
      errors.desc = "City must not be empty!"
    }
    else{
      delete errors.city
    }

    if(validator.isEmpty(province.replaceAll(" ", ''))){
      errors.desc = "Province must not be empty!"
    }
    else{
      delete errors.province
    }

    if(validator.isEmpty(postalcode.replaceAll(" ", ''))){
      errors.desc = "Postal Code must not be empty!"
    }
    else{
      delete errors.postalcode
    }

    if(validator.isEmpty(country.replaceAll(" ", ''))){
      errors.desc = "Country must not be empty!"
    }
    else{
      delete errors.country
    }

    if(validator.isEmpty(maxdistance.replaceAll(" ", ''))){
      errors.desc = "Max Distance must not be empty!"
    }
    else{
      delete errors.maxdistance
    }

    console.log(errors)
    $("#fnameError").text(errors?.fname?errors.fname : "")
    $("#lnameError").text(errors?.lname?errors.lname : "")
    $("#bdayError").text(errors?.bday?errors.bday : "")
    $("#descError").text(errors?.desc ?errors.desc : "")
    $("#addressError").text(errors?.desc ?errors.desc : "")
    $("#cityError").text(errors?.desc ?errors.desc : "")
    $("#provinceError").text(errors?.desc ?errors.desc : "")
    $("#postalcodeError").text(errors?.desc ?errors.desc : "")
    $("#countryError").text(errors?.desc ?errors.desc : "")
    $("#maxdistanceError").text(errors?.desc ?errors.desc : "")

    if(Object.keys(errors).length === 0){
      // No ERRORS do what you have to do
      $("#patientForm").submit()
    }
    else{
      e.preventDefault()
    }
  }
</script>
</body>
</html>