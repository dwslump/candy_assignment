<?php include('inc/header.php') ?>
	<div id="body">
		<h2>Let's buy some candy?</h2>
		<a href='<?php echo base_url()."candystore/view_cart";?>' ><span id="button">View Cart</span></a>
		<?php 
		$cart =  $this->session->userdata('user_cart');
			
		if(!$cart){ // User has no order
			
			$emptycart = array();
			$this->session->set_userdata('user_cart', $emptycart);
			$this->session->set_userdata('cartTotal', 0);
		}
		
		echo form_open('candystore/cart_manager');
		echo "<table class='table'>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th><th colspan='2'></th></tr>";
		$counter=1;
		$set_range = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
		foreach ($products as $product) {			
			echo "<tr>";
			echo form_hidden('product_id'.$counter,$product->id);
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";			
			echo "<td>Quantity: " .form_dropdown('product_quantity'.$counter, $set_range). "</td>";
			echo "<td>" .form_submit('submitProduct'.$counter, 'Add to cart'). "</td>";			
			echo "</tr>";
			$counter++;
		}
		echo "</table>";
		echo form_hidden('amount_products',$counter-1);
		echo form_close();
		?>
		
	</div>
		
	<div id="bottom">			
		<a href='<?php echo base_url()."candystore/logout";?>' ><span id="button">Logout</span></a>
	</div>
<?php include('inc/footer.php') ?>