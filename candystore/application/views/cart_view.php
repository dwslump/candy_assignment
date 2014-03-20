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
		<p>Hello <?php echo $this->session->userdata['login'] ?>, this is your cart:</p>			
	
		<?php 
		$cart =  $this->session->userdata('user_cart');
		$cart_items = $cart->cart_items;
		if(!count(cart_items) == 0 ){ // Empty cart!
			echo "<p>Your cart is empty!</p>";
		}else{
			
			echo "<table>";
			echo "<tr><th>Name</th><th>Description</th><th>Quantity</th><th>Price</th></tr>";
			
			foreach ($products as $product) {
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
		}
		
		?>
		
		</div>
		
		<div id="bottom">
			<a href='<?php echo base_url()."candystore/logout";?>' >Logout</a>
			<a href='<?php echo base_url()."candystore/logout";?>' >Logout</a>
		</div>
	

</body>
</html>