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
		$this->load->model('product_model');
		$cart_items = $this->session->userdata('user_cart'); 
		$total=0;
		if(!$cart_items){ // Empty cart!
			echo "<p>Your cart is empty!</p>";
		}else{
			
			echo "<table>";
			echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Image</th><th>Quantity</th></tr>";			
			foreach ($cart_items as $order_item) {
				$helper = unserialize($order_item);
				$query = $this->db->get_where('product',array('id' => $helper->product_id));								
				$product = $query->row(0,'Product');
				echo "<tr>";
				echo "<td>" . $product->name . "</td>";
				echo "<td>" . $product->description . "</td>";
				echo "<td>" . $product->price . "</td>";
				echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				echo "<td>". $helper->quantity ."</td>";
				echo "</tr>";
				
			}
			echo "<tr>";
			echo "<td>Total: ". $this->session->userdata('cartTotal') ."</td>";
			echo "</tr>";
			echo "<table>";	
		}
		
		?>
		
		</div>
		
		<div id="bottom">
<!-- 			<a href='javascript:history.back()' >Back</a><br> -->
			<a href='<?php echo base_url()."candystore/index";?>' >Continue Shopping</a><br>
			<a href='<?php echo base_url()."candystore/checkout";?>' >Checkout</a>
		</div>
		
		
	

</body>
</html>