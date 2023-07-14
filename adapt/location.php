<?php
require_once("Model/User.php");
session_start();
$Connection = new Connection();
$con = $Connection->buildConnection();
$patient_id = $_POST['patient_id'];
echo $patient_id;

?>
<html>
<?php 
include("Controller/header.php");
?>
<head> 
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBssNE8WDuC_GDRcX-M8psRSgl4Yae6Dcw"></script>
  <style>
    #map {height: 750px;
      width: 100%;
    }
  </style>
</head>

<body>
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
<div>
    <label for="address">Address:</label>
    <input type="text" id="address" />
    <label for="city">City:</label>
    <input type="text" id="city" />
    <label for="province">Province:</label>
    <input type="text" id="province" />
    <label for="postal_code">Postal Code:</label>
    <input type="text" id="postal_code" />
    <label for="country">Country:</label>
    <input type="text" id="country" />
    <label for="radius">Radius (in meters):</label>
    <input type="number" id="radius" />
    <button onclick="searchAddress()">Search</button>
  </div>

  <div id="map"></div>

  <script>
    let map;
    let geocoder;
    let geofenceCircle;

    function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 14.55983512128611, lng: 121.00816141964367 }, 
        zoom: 18 
      });

      geocoder = new google.maps.Geocoder();
    }

    function searchAddress() {
      const address = document.getElementById('address').value;
      const city = document.getElementById('city').value;
      const province = document.getElementById('province').value;
      const postalCode = document.getElementById('postal_code').value;
      const country = document.getElementById('country').value;
      const radius = parseFloat(document.getElementById('radius').value);

      const fullAddress = `${address}, ${city}, ${province}, ${postalCode}, ${country}`;

      geocoder.geocode({ address: fullAddress }, (results, status) => {
        if (status === 'OK' && results.length > 0) {
          const location = results[0].geometry.location;

          // Update the map center and add a marker
          map.setCenter(location);
          new google.maps.Marker({
            map: map,
            position: location,
          });

          // Clear existing geofence circle, if any
          if (geofenceCircle) {
            geofenceCircle.setMap(null);
          }

          // Create a geofence circle
          geofenceCircle = new google.maps.Circle({
            center: location,
            radius: radius,
            editable: true, // Set to true to allow editing the circle
            draggable: true, // Set to true to allow dragging the circle
            map: map,
          });

          // Add event listener to detect changes to the circle
          google.maps.event.addListener(geofenceCircle, 'radius_changed', function() {
            // Handle changes to the geofence circle radius
            console.log('Geofence circle radius modified:', geofenceCircle.getRadius());
          });
        } else {
          console.log('Geocode was not successful for the following reason:', status);
        }
      });
    }
  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBssNE8WDuC_GDRcX-M8psRSgl4Yae6Dcw&callback=initMap"></script>

</body>

</html>