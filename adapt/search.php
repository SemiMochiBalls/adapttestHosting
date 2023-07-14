<?php 
require_once("Model/User.php");
session_start();
$search = $_POST['search'];
if(!$search){
	header("location:index.php");
}else{
	$Connection = new Connection();
	$con = $Connection->buildConnection();
	$statement = $con->query("SELECT * FROM products WHERE product_name LIKE '%$search%'");
	$fetch =  $statement->fetch_assoc();
}

?>
<html>
<?php 
include("Controller/header.php");
?>
<body>
<?php
include("Controller/nav.php");
?>
<div class="shopcon">
	<div class="row">
		<div class="col">
			<div class="confirmcontainer">
					<p><?= $fetch['product_name'] ?></p>
					<p><img src="img/<?= $fetch['product_id'] . '.' . $fetch['product_image'] ?>" class="productimg"></p>
					<p>₱<?= $fetch['product_price'] ?></p>
			</div>
		</div>
	</div>
</div>
</body>
</html>