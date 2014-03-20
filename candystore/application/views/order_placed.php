<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CandyStore</title>
    <script type="text/javascript" src="<?php echo base_url();?>js/print.js" ></script>
</head>
<body>

<div>
	<h1>Order Recipt</h1>
</div>
	<div id="body">
		<p><?php
		$query = $this->db->get_where('customer',array('id' => $this->session->userdata('user_id')));		
		$row = $query->row();
		$usrF = $row->first;
		$usrL = $row->last;
		echo "Buyer: " .$usrL. ", ".$usrF.".";
		$order_date = "%Y,%m,%d";
		$order_time = "%h:%i %a";
		$time = time();
		echo " Order placed at ".mdate($order_time, $time)." on ".mdate($order_date, $time);
// 		echo var_dump($query); 
		?>.</p>
		
		<p>Order:</p>			
	
		<?php 
		$this->load->model('product_model');
		$cart_items = $this->session->userdata('user_cart'); 
		$total=0;
		if(!$cart_items){ // Empty cart!
			echo "<p>Your cart is empty!</p>";
		}else{			
			echo "<table>";
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
			echo "<td>Total ". $this->session->userdata('cartTotal') ."</td>";
			echo "</tr>";
			echo "<table>";	
		}
		
		?>
		</div>
	
		<form>
		<input type=button value="Print"
		onClick="window.print()">
		</form>

		
		
		<div id="bottom">
<!-- 		<a href='javascript:history.back()' >Back</a><br> -->
			<a href='<?php echo base_url()."candystore/view_cart";?>' >Change your Order</a><br>
		</div>
		
		<div id="bottom">
			<a href='<?php echo base_url()."candystore/logout";?>' >Logout</a>
		</div>
		
	

</body>
</html>