<?php include('inc/header.php'); ?>
	<div id="body">
		<h1>Checkout your Order</h1>
		<p><?php echo $this->session->userdata['login'] ?>, this is the checkout screen.</p>
		
		<p>Here is your order:</p>			
	
		<?php 
		$this->load->model('product_model');
		$cart_items = $this->session->userdata('user_cart'); 
		$total=0;
		if(!$cart_items){ // Empty cart!
			echo "<p>Your cart is empty!</p>";
		}else{
			
			echo "<table class='table'>";
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
			echo "<td colspan='5'>Total you must pay: $". $this->session->userdata('cartTotal') ."</td>";
			echo "</tr>";
			echo "</table>";	
		}
		
		?>

		<p>Please, insert your payment data bellow to conclude your purchase.</p>
	
		<?php 
		echo "<div class='login'>";
 		echo form_open('candystore/finalize_purchase');
		
 		echo validation_errors();
		
		
		
		echo "<p>Credit Card Number: <br>";
		echo form_input('cnumber');
		echo "</p>";
		
		echo "<p>Credit Card Month: <br>";
		echo form_input('cmonth');
		echo "</p>";

		echo "<p>Credit Card Year: <br>";
		echo form_input('cyear');
		echo "</p>";
		
		echo "<p>";
		echo form_submit('submit_finalize', 'Submit');
		echo "</p>";
		
		echo form_close();
		echo "</div>";
		
		?>
		
		</div>
		
		<div id="bottom" style="margin-top: 20px">
<!-- 			<a href='javascript:history.back()' >Back</a><br> -->
			<a href='<?php echo base_url()."candystore/view_cart";?>' ><span id="button">Change your Order</span></a>
			<a href='<?php echo base_url()."candystore/logout";?>' ><span id="button">Logout</span></a>
		</div>
		
<?php include('inc/footer.php'); ?>