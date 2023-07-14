<?php
require_once("Model/User.php");
session_start();
$Connection = new Connection();
$con = $Connection->buildConnection();
$patient_id = $_POST['patient_id'];

$location = $con -> query("SELECT * FROM patients WHERE patient_id = $patient_id");
$fetch = $location -> fetch_assoc();

?>
<html>
<?php 
include("Controller/header.php");
?>
<head> 
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBssNE8WDuC_GDRcX-M8psRSgl4Yae6Dcw"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">  
  <style>
    #map {
      position: absolute;
      top: 100px;
      left: 0;
      bottom: 0;
      right: 0;
    }
    .back-btn {
      z-index: 9999999999999999;
      position: absolute;
      right: 60px;
      top: 79px;
      background-color: #3367d6;
      padding: 0.5rem 1rem;
      text-align: center;
      border: 0;
      text-decoration: none;
      font-family: 'Roboto', sans-serif;
      font-weight: 500;
      color: #FFFFFF;
    }

    .back-btn:hover {
      text-decoration: none;
    }
  </style>
</head>

<body onload="searchAddress()">
<?php
if(isset($success)){
?>
<div class="jumbotron">
	<ul>
		<?php
		foreach ($success as $key => $value) {
		?>
		<li><?= $value ?></li>
		<?php
		}
		?>
	</ul>
</div>
<?php
}
include("Controller/nav.php");
?>

</div>
<?php include("Controller/script.php")?>
</br>
<div style="display: none;">
    <label for="address">Address:</label>
    <input type="text" id="address" value="<?=$fetch['patient_address']?>"/>
    <label for="city">City:</label>
    <input type="text" id="city" value="<?=$fetch['patient_city']?>"/>
    <label for="province">Province:</label>
    <input type="text" id="province" value="<?=$fetch['patient_province']?>"/>
    <label for="postalcode">Postal Code:</label>
    <input type="text" id="postalcode" value="<?=$fetch['patient_postalcode']?>"/>
    <label for="country">Country:</label>
    <input type="text" id="country" value="<?=$fetch['patient_country']?>"/>
    <label for="maxdistance">Radius (in meters):</label>
    <input type="number" id="maxdistance" value="<?=$fetch['patient_maxdistance']?>"/>
    <button>Search</button>
  </div>

  <div id="map"></div>
  <a href="manage.php" class="back-btn">Back</a>

  <div id="modal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>Out-of-Bounds Alert</h2>
      <p>The dummy coordinate is outside the geofence!</p>
    </div>
  </div>

  <script>
    let map;
    let geocoder;
    let dummyCoordinateMarker;
    let geofenceCircle;
    let modal;

    function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
        center: { 
          lat: 14.55983512128611, 
          lng: 121.00816141964367 }, 
          zoom: 19 
      });

      geocoder = new google.maps.Geocoder();
    }

    function searchAddress() {
      const address = document.getElementById('address').value;
      const city = document.getElementById('city').value;
      const province = document.getElementById('province').value;
      const postalCode = document.getElementById('postalcode').value;
      const country = document.getElementById('country').value;
      const radius = parseFloat(document.getElementById('maxdistance').value);

      if (!validateAddress(address, city, province, postalCode, country)) {
        alert('Please enter a valid address, city, province, postal code, and country.');
        return;
      }
    
    const fullAddress = `${address}, ${city}, ${province}, ${postalCode}, ${country}`;

      geocoder.geocode({ address: fullAddress }, (results, status) => {
        if (status === 'OK' && results.length > 0) {
          const location = results[0].geometry.location;

          map.setCenter(location);
          new google.maps.Marker({
            map: map,
            position: location,
          });

          if (dummyCoordinateMarker) {
            dummyCoordinateMarker.setMap(null);
          }
          if (geofenceCircle) {
            geofenceCircle.setMap(null);
          }

          dummyCoordinateMarker = new google.maps.Marker({
            map: map,
            position: {
              lat: 14.61187583183809, 
             lng: 121.00646580177182
            },
            icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png' 
          });

          geofenceCircle = new google.maps.Circle({
            center: location,
            radius: radius,
            editable: false, 
            draggable: false, 
            map: map,
          });

          
          google.maps.event.addListener(geofenceCircle, 'radius_changed', function() {
            
            console.log('Geofence circle radius modified:', geofenceCircle.getRadius());
          });

          const dummyCoordinate = location;
          
          if (!google.maps.geometry.spherical.containsLocation(dummyCoordinate, geofenceCircle)) {
            
            alert('Warning: The PATIENT is outside the geofence!');
          }
        } else {
          console.log('Geocode was not successful for the following reason:', status);
        }
      });
    }

   
    function validateAddress(address, city, province, postalCode, country) {
      return address.trim() !== '' && city.trim() !== '' && province.trim() !== '' && postalCode.trim() !== '' && country.trim() !== '';
    }

    function openModal() {
      modal.style.display = 'block';
    }

    function closeModal() {
      modal.style.display = 'none';
    }
  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBssNE8WDuC_GDRcX-M8psRSgl4Yae6Dcw&libraries=geometry&callback=initMap"></script>

</body>

</html>
