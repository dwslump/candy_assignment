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
		<p>Admin Session</p>
	
		<h2>Order Management</h2>
	
		<?php
			echo "<p>" . anchor('candystore/index','Back') . "</p>";
		
			echo "<table>";
			echo "<tr><th>Order Date</th><th>Order Time</th><th>Total</th><th>Products</th><th>Quantity</th></tr>";
				
			foreach ($orders as $order) {
				echo "<tr>";
				echo "<td>" . $order->order_date . "</td>";
				echo "<td>" . $order->order_time . "</td>";
				echo "<td>" . $order->total . "</td>";
				echo "<td>";
				foreach($order_items as $order_item){
					foreach($products_order as $product_order){
						if($order_item->product_id == $product_order->id){
							echo $product_order->name ."<br>";
						}
					}
				}
				echo "</td>";
				foreach($order_items as $order_item){
					foreach($products_order as $product_order){
						if($order_item->product_id == $product_order->id){
							echo $order_item->quantity ."<br>";
						}
					}
				}
				"</td>";
				
				echo "<td>" . anchor("candystore/delete_order/$order->id",'Delete',"onClick='return confirm(\"Do you really want to delete this order information?\");'") . "</td>";
			
				echo "</tr>";
			}
			
			echo "</table>";
		?>
		
		</div>
		
		<div id="bottom">
			<a href='<?php echo base_url()."candystore/logout";?>' >Logout</a>
		</div>
	

</body>
</html>