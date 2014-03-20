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
		<a href='<?php echo base_url()."candystore/view_cart";?>' >View Cart</a>
		<?php 
		$cart =  $this->session->userdata('user_cart');
			
		if(!$cart){ // User has no order
			
			$emptycart = array();
			$this->session->set_userdata('user_cart', $emptycart);
			$this->session->set_userdata('cartTotal', 0);
		}
		
		echo form_open('candystore/cart_manager');
		echo "<table>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		$counter=1;
		foreach ($products as $product) {			
			echo "<tr>";
			echo form_hidden('product_id'.$counter,$product->id);
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";			
			echo "<td>Quantity: " .form_input('product_quantity'.$counter). "</td>";
			echo "<td>" .form_submit('submitProduct'.$counter, 'Add to cart'). "</td>";			
			echo "</tr>";
			$counter++;
		}
		echo "<table>";
		echo form_hidden('amount_products',$counter-1);
		echo form_close();
		?>
		
		</div>
		
		<div id="bottom">			
			<a href='<?php echo base_url()."candystore/logout";?>' >Logout</a>
		</div>
	

</body>
</html>