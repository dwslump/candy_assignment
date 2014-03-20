<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CandyStore</title>

</head>
<body>

<div>
	<h1>Welcome to CandyStore</h1>
</div>
	<div id="body">
		<p>Welcome back, <?php echo $this->session->userdata['login'] ?>!</p>
		
		<p>Let's buy some candy?</p>
	
		<?php 
		$cart =  $this->session->userdata('user_cart');
		$order_date = "%Y,%m,%d";		
		$order_time = "%h:%i %a";
		$time = time();
			
		if(!$cart){ // User has no order
			$emptycart = array(
					'cart_items'=>array()
			);
			$this->session->set_userdata('user_cart', $emptycart);
		}
		
		
		echo "<table>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($order_items as $order_items) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";			
			echo "<td>Quantity: <input type='text' name='quantity'></td>";
			echo "<td><button type='button'>Add to cart</button></td>";	
			echo "</tr>";
		}
		echo "<table>";
		
		?>
		
		</div>
		
		<div id="bottom">
			<a href='<?php echo base_url()."candystore/logout";?>' >Logout</a>
			<a href='<?php echo base_url()."candystore/logout";?>' >Logout</a>
		</div>
	

</body>
</html>