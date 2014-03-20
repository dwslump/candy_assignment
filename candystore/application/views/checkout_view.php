<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CandyStore</title>

</head>
<body>

<div>
	<h1>Checkout</h1>
</div>
	<div id="body">
		<p>Hello, <?php echo $this->session->userdata['login'] ?>, this is the checkout screen.</p>
		
<div id="body">
		<p>Please, insert your payment data bellow to concluse your purchase.</p>
	
		<?php 
		
 		echo form_open('candystore/finalize_purchase');
		
// 		echo validation_errors();
		
		
		
		echo "<p>Credit Card Number: ";
		echo form_input('cnumber');
		echo "</p>";
		
		echo "<p>Credit Card Month: ";
		echo form_input('cmonth');
		echo "</p>";

		echo "<p>Credit Card Year: ";
		echo form_input('cyear');
		echo "</p>";
		
		echo "<p>";
		echo form_submit('submit_finalize', 'Submit');
		echo "</p>";
		
		echo form_close();
		
		?>
		
		</div>
		
		<div id="bottom">
<!-- 			<a href='javascript:history.back()' >Back</a><br> -->
			<a href='<?php echo base_url()."candystore/view_cart";?>' >Back</a><br>
			<a href='<?php echo base_url()."candystore/finalize_purchase";?>' >Checkout</a>
		</div>
	

</body>
</html>