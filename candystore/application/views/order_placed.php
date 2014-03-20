<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CandyStore</title>
</head>
<body>
	<div id="body">
		<h1>Order Receipt</h1>
		<p><?php
		$query = $this->db->get_where('customer',array('id' => $this->session->userdata('user_id')));		
		$row = $query->row();
		$usrF = $row->first;
		$usrL = $row->last;
		echo "<table class='table'>";
		echo "<tr><td>Buyer: " .$usrL. ", ".$usrF.".</td>";
		$order_date = "%Y,%m,%d";
		$order_time = "%h:%i %a";
		$time = time();
		echo "<td>Order placed at ".mdate($order_time, $time)." on ".mdate($order_date, $time) . "</td></tr>";
		echo "</table>";
// 		echo var_dump($query); 
		?>.</p>
		
		<tr><p>Order:</p></tr>			
	
		<?php 
		$this->load->model('product_model');
		$cart_items = $this->session->userdata('user_cart'); 
		$total=0;
		if(!$cart_items){ // Empty cart!
			echo "<p>Your cart is empty!</p>";
		}else{			
			echo "<table class='table'>";
			echo "<tr><th>Name</th><th>Price Un. </th><th>Quantity</th><th>Price Total</th></tr>";			
			foreach ($cart_items as $order_item) {
				$helper = unserialize($order_item);
				$query = $this->db->get_where('product',array('id' => $helper->product_id));								
				$product = $query->row(0,'Product');
				echo "<tr>";
				echo "<td>" . $product->name . "</td>";
				echo "<td>" . $product->price . "</td>";
				echo "<td>x". $helper->quantity ."</td>";
				echo "<td>". $helper->quantity*$product->price ."</td>";
				echo "</tr>";
				
			}
			echo "<tr>";
			echo "<td colspan='4'>Total Amount: $". $this->session->userdata('cartTotal') ."</td>";
			echo "</tr>";
			echo "<table>";	
		}
		
		//we must certify that the session has been over.
		$this->session->sess_destroy();
		
		?>
		</div>
		<form>
		<input type=button value="Print"
		onClick="window.print()">
		</form>
		
		
		<div id="bottom">
			<div class="table"><p>Thanks for buying! You must login again if you want to place another order.</p></div>
			<a href='<?php echo base_url()."candystore/logout";?>' ><span id="button">Login</span></a>
		</div>
		
	

</body>
</html>