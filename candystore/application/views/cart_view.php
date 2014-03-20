<?php include('inc/header.php'); ?>
	<div id="body">
		<h3>Hello <b><?php echo $this->session->userdata['login'] ?></b>, this is your cart:</h3>			
	
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
			echo "<td colspan='5'>Total Amount: $". $this->session->userdata('cartTotal') ."</td>";
			echo "</tr>";
			echo "</table>";	
		}
		
		?>
		
		</div>
		
		<div id="bottom">
<!-- 			<a href='javascript:history.back()' >Back</a><br> -->
			<a href='<?php echo base_url()."candystore/index";?>' ><span id="button">Continue Shopping</span></a>
			<a href='<?php echo base_url()."candystore/checkout";?>' ><span id="button">Checkout</span></a>
		</div>

<?php include('inc/footer.php'); ?>