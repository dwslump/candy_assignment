<?php include('inc/header.php'); ?>
<h2>Customer Info</h2>
<?php 
	echo "<p>" . anchor('candystore/index','<span id="button">Back</span>') . "</p>";
	echo "<div class='table'>";
	echo "<p> ID = " . $customer->id . "</p>";
	echo "<p> FIRST NAME = " . $customer->first . "</p>";
	echo "<p> LAST NAME = " . $customer->last . "</p>";
	echo "<p> Login = " . $customer->login . "</p>";
	echo "<p> Password = ******** (you should not access this ;D)</p>";
	echo "<p> E-mail = " . $customer->email . "</p>";
	echo "</div>"
?>	

<?php include('inc/footer.php'); ?>