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
<body style="background-image: url('img/hero-bg.png'); background-repeat: no-repeat; background-size: cover;">
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
	<div class="container hero">
		<h1><span class="green">Keeping track of the<br/> ones that are<br/></span> <span class="orange">unforgettable.</span></h1>
		<p>Revolutionize the way you care for your loved one with Alzheimer's<br/>
			or dementia! Our website offers an easy-to-use tracking system to<br/> 
			monitor their activities. Record health information and share it with<br/>
			healthcare providers for better care. Try it today!
		</p>
		<a href="register.php">Sign Up</a>
		<a href="about.php">More Info</a>
	</div>
<?php include("Controller/script.php")?>
</body>
</html>