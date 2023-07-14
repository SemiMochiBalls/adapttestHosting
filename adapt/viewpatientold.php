<?php
require_once("Model/User.php");
session_start();
date_default_timezone_set("Asia/Manila");
$Connection = new Connection();
$con = $Connection->buildConnection();
function repeatDecode($num, $string){
    $num %= 7;
    for($i = $num + 3 ; $i > 0 ; $i--){
        $string = base64_decode($string);
    }
    return $string;
  }
function repeatEncode($num, $string){
    $num %= 7;
    for($i = $num + 2 ; $i > 0 ; $i--){
        $string = base64_encode($string);
    }
    return $string;
}
if(isset($_GET['patient_id'])){
    $patient_id = $_GET['patient_id'];
    $viewpatient = $con->query("SELECT * FROM patients WHERE patient_id LIKE $patient_id");
    $fetch = $viewpatient->fetch_assoc();
    if(empty($fetch))
        header("location: manage.php");
    else{
        $patient_fname=repeatDecode($fetch['patient_id'], $fetch['patient_fname']);
        $patient_lname=repeatDecode($fetch['patient_id'], $fetch['patient_lname']);
        $patient_age=date_diff(date_create($fetch['patient_bday']), date_create())->format('%y');
    }
}
else if(!isset($_POST['patient_id'])){
    header("location: manage.php");
}
if(count($_POST) > 10){
    $firstname = base64_encode($_POST['firstname']);
    $lastname = base64_encode($_POST['lastname']);
    $bday = $_POST['birthday'];
    $patient_id = $_POST['patient_id'];
    $desc = $_POST['desc'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $postalcode = $_POST['postalcode'];
    $country = $_POST['country'];
    $maxdistance = $_POST['maxdistance'];
    $mpStatement = $con->prepare("UPDATE patients SET patient_fname = ?, patient_lname = ?, patient_bday = ?, patient_desc = ?, patient_address = ?, patient_city = ?, patient_province = ?, patient_postalcode = ?, patient_country = ?, patient_maxdistance = ? WHERE patient_id = ?");
    $mpStatement->bind_param("sssssssisdi",repeatEncode($patient_id, $firstname),repeatEncode($patient_id, $lastname),$bday,$desc,$address,$city,$province,$postalcode,$country,$maxdistance,$patient_id);
    $mpStatement->execute();
    $mpStatement->close();
    $_SESSION['success'] = array ("Patient Edited");
    header("location:viewpatientold.php?patient_id=$patient_id");
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
	unset($_SESSION['success']);
}
if(isset($success)){
?>
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="sucessModalHeader" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalTitle">Patient Edited</h5>
        <button type="button" class="closebutton" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <p>Patient has been successfully edited to the patient database.</p>
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
<div class="container" style="margin-top: 5%; text-align:center;"><hr>
    <div class="row">
        <div class="col">
            First Name: <?= $patient_fname?>
        </div>
        <div class="col">
            Last Name: <?= $patient_lname?>
        </div>
    </div><br>
    <div class="row">
        <div class="col">
            Age: <?= $patient_age?>
        </div>
    </div><br>
    <div class="row">
        <div class="col">
            Description: <?=$fetch['patient_desc']?>
        </div>
    </div><br>
    <div class="row">
            <div class="col">
              <label for="address">Address:</label>
              <p class="form-control"><?= $fetch['patient_address']?></p>
            </div>
            <div class="col">
              <label for="city">City:</label>
              <p class="form-control"><?= $fetch['patient_city']?></p>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="province">Province:</label>
              <p class="form-control"><?= $fetch['patient_province']?></p>
            </div>
            <div class="col">
              <label for="postalcode">Postal Code:</label>
              <p class="form-control"><?= $fetch['patient_postalcode']?></p>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="country">Country:</label>
              <p class="form-control"><?= $fetch['patient_country']?></p>
            </div>
            <div class="col">
              <label for="maxdistance">Max Distance:</label>
              <p class="form-control"><?= $fetch['patient_maxdistance']?></p>
            </div>
          </div>
    <div class="row">
        <div class="col">
            <!-- Edit Patient Button Modal -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editPatient">
                Edit Patient
            </button>
        </div>
        <div class="col">
            <form action="location.php" method="POST">
                <input type="hidden" name="patient_id" id="patient_id" value="<?= $fetch['patient_id']?>">
                <input type="submit" value="Check Location" class="btn btn-success"></input>
            </form>
        </div>
    </div>
</div>
<!-- Modal for Edit Patient -->
<div class="modal fade" id="editPatient" tabindex="-1" role="dialog" aria-labelledby="editPatientHeader" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPatientTitle">Edit patient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="viewpatientold.php" onsubmit="formSubmit(event)" id="patientForm" method="POST">
        <input type="hidden" name="patient_id" value=<?=$patient_id?> />
        <div class="form-group">
          <div class="row">
            <div class="col">
              <label for="firstname">Firstname:</label>
              <input type="text" class="form-control" name="firstname" value="<?=$patient_fname?>" id="firstname" placeholder="Enter First Name" required>
              <small style="color:red" id="fnameError"></small>
            </div>
            <div class="col">
              <label for="lastname">Lastname:</label>
              <input type="text" class="form-control" name="lastname" value="<?=$patient_lname?>" id="lastname" placeholder="Enter Last Name" required>
              <small style="color:red" id="lnameError"></small>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="birthday">Birthdate:</label>
          <input type="date" class="form-control" name="birthday" value="<?=$fetch['patient_bday']?>" id="birthday" required>
          <small style="color:red" id="bdayError"></small>
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea class="form-control" name="desc" id="desc" placeholder="Enter Description" rows="4" required><?=$fetch['patient_desc']?></textarea>
          <small style="color:red" id="descError"></small>
        </div>
        <div class="row">
            <div class="col">
              <label for="address">Address:</label>
              <input type="text" class="form-control" name="address" value="<?=$fetch['patient_address']?>" id="address" placeholder="Enter First Name" required>
              <small style="color:red" id="addressError"></small>
            </div>
            <div class="col">
              <label for="city">City:</label>
              <input type="text" class="form-control" name="city" value="<?=$fetch['patient_city']?>" id="city" placeholder="Enter Last Name" required>
              <small style="color:red" id="cityError"></small>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="province">Province:</label>
              <input type="text" class="form-control" name="province" value="<?=$fetch['patient_province']?>" id="province" placeholder="Enter First Name" required>
              <small style="color:red" id="provinceError"></small>
            </div>
            <div class="col">
              <label for="postalcode">Postal Code:</label>
              <input type="text" class="form-control" name="postalcode" value="<?=$fetch['patient_postalcode']?>" id="postalcode" placeholder="Enter Last Name" required>
              <small style="color:red" id="postalcodeError"></small>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="country">Country:</label>
              <input type="text" class="form-control" name="country" value="<?=$fetch['patient_country']?>" id="country" placeholder="Enter First Name" required>
              <small style="color:red" id="countryError"></small>
            </div>
            <div class="col">
              <label for="maxdistance">Max Distance:</label>
              <input type="text" class="form-control" name="maxdistance" value="<?=$fetch['patient_maxdistance']?>" id="maxdistance" placeholder="Enter Last Name" required>
              <small style="color:red" id="maxdistanceError"></small>
            </div>
          </div>
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
    const postalcode = $("#psotalcode").val()
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
    if(!validator.isAlpha(address, 'en-US' ,{ignore: " -"}) || validator.isEmpty(address.replaceAll(" ", ""))){
      errors.address = "Address is invalid!"
    }
    else{
      delete errors.address
    }
    if(!validator.isAlpha(city, 'en-US' ,{ignore: " -"}) || validator.isEmpty(city.replaceAll(" ", ""))){
      errors.city = "City is invalid!"
    }
    else{
      delete errors.city
    }
    if(!validator.isAlpha(province, 'en-US' ,{ignore: " -"}) || validator.isEmpty(province.replaceAll(" ", ""))){
      errors.province = "Province is invalid!"
    }
    else{
      delete errors.province
    }
    if(!validator.isAlpha(postalcode, 'en-US' ,{ignore: " -"}) || validator.isEmpty(postalcode.replaceAll(" ", ""))){
      errors.lname = "Last name is invalid!"
    }
    else{
      delete errors.postalcode
    }
    if(!validator.isAlpha(country, 'en-US' ,{ignore: " -"}) || validator.isEmpty(country.replaceAll(" ", ""))){
      errors.country = "Last name is invalid!"
    }
    else{
      delete errors.country
    }
    if(!validator.isAlpha(maxdistance, 'en-US' ,{ignore: " -"}) || validator.isEmpty(maxdistance.replaceAll(" ", ""))){
      errors.maxdistance = "Last name is invalid!"
    }
    else{
      delete errors.maxdistance
    }
    console.log(errors)
     $("#fnameError").text(errors?.fname?errors.fname : "")
    $("#lnameError").text(errors?.lname?errors.lname : "")
    $("#bdayError").text(errors?.bday?errors.bday : "")
    $("#descError").text(errors?.desc ?errors.desc : "")
    $("#addressError").text(errors?.address ?errors.address : "")
    $("#cityError").text(errors?.city ?errors.city : "")
    $("#provinceError").text(errors?.province ?errors.province : "")
    $("#postalcodeError").text(errors?.postalcode ?errors.postalcode : "")
    $("#countryError").text(errors?.country ?errors.country : "")
    $("#maxdistanceError").text(errors?.maxdistance ?errors.maxdistance : "")
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