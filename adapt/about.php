<?php
require_once("Model/User.php");
session_start();
$Connection = new Connection();
$con = $Connection->buildConnection();

?>
<html>
<?php 
include("Controller/header.php");
?>
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
<img src="img/light-theme-logo-vertical.svg" style="display: block; margin:auto; padding: 3rem 0;"/>
<div class="center-text mx-auto" style="width:800px;">
	<p>
		Welcome to ADAPT, the website designed to help Alzheimer's and dementia patients and their caregivers. We are<br/> 
		passionate about providing a solution that simplifies and improves the lives of those affected by these<br/>
		conditions.
	</p>
	<p>
		Our team understands the challenges that come with caring for a loved one with Alzheimer's or dementia, which<br/>
		is why we've created an easy-to-use website that allows you to track your loved one's activities to keep them<br/>
		safe.
	</p>
	<p>
		We strive to empower caregivers and patients by providing them with the tools they need to manage these<br/>
		conditions with confidence. Our website is designed to relieve stress and promote peace of mind, allowing you to<br/>
		focus on what truly matters - the wellbeing of your loved one.<br/>
		Join us on this journey towards better care and a better future. Try ADAPT today and take the first step towards<br/> a brighter tomorrow.
	</p>
</div>

<h3 class="green" style="text-align: center; margin: 5rem 0 2rem 0;">Contact us for any concerns</h3>
<p style="text-align: center;">iAcademy Nexus Campus 7434, Yakal, Makati 1203</p>
<p style="text-align: center;">0917 110 3996</p>
<p style="text-align: center;">adaptsupport@gmail.com</p>
<?php include("Controller/script.php")?>
</body>
</html>