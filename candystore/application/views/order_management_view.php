<?php include('inc/header.php'); ?>
	<h4 id="session">Admin Session</h4>
	<div id="body">

		<h2>Order Management</h2>
	
		<?php
			echo "<p>" . anchor('candystore/index','<div id="button">Back</div>') . "</p>";
		
			echo "<table class='table'>";
			echo "<tr><th>Order ID</th><th>Order Date</th><th>Order Time</th><th>Total</th><th>Products</th><th>Quantity</th><th></th></tr>";
				
			foreach ($orders as $order) {
				echo "<tr>";
				echo "<td>" . $order->id . "</td>";
				echo "<td>" . $order->order_date . "</td>";
				echo "<td>" . $order->order_time . "</td>";
				echo "<td>" . $order->total . "</td>";
				echo "<td>";
				foreach($order_items as $order_item){
					foreach($products_order as $product_order){
						if(($order_item->product_id == $product_order->id) and ($order->id == $order_item->order_id)){
							echo $product_order->name ."<br>";
						}
					}
				}
				echo "</td>";
				echo "<td>";	
				foreach($order_items as $order_item){
					foreach($products_order as $product_order){
						if(($order_item->product_id == $product_order->id) and ($order->id == $order_item->order_id)){
							echo $order_item->quantity ."<br>";
						}
					}
				}
				"</td>";
				
				echo "<td>" . anchor("candystore/delete_order/$order->id",'<span id="button">Delete</span>',"onClick='return confirm(\"Do you really want to delete this order information?\");'") . "</td>";
			
				echo "</tr>";
			}
			
			echo "</table>";
		?>
		
	</div>
	
	<div id="bottom">
		<a href='<?php echo base_url()."candystore/logout";?>' ><div id="button">Logout</div></a>
	</div>
<?php include('inc/footer.php') ?>