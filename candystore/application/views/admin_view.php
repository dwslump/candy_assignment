<?php include('inc/header.php'); ?>
	<h4 id="session">Admin Session</h4>
	<div id="body">
	
		<h2>Product Manager</h2>
		<p>You can manage all products bellow:</p>	
	
		<?php 
		echo "<p>" . anchor('candystore/newForm','<div id="button">Add New</div>') . "</p>";
 	  
		echo "<table class='table'>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th><th colspan='3'></th></tr>";
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				
			echo "<td>" . anchor("candystore/delete/$product->id",'<span id="button">Delete</span>',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
			echo "<td>" . anchor("candystore/editForm/$product->id",'<span id="button">Edit</span>') . "</td>";
			echo "<td>" . anchor("candystore/read/$product->id",'<span id="button">View</span>') . "</td>";
				
			echo "</tr>";
		}
		echo "</table>";
		
		?>
		
		<h2>Customer Manager</h2>
		
		<p>You can manage all the customers bellow:</p>
		
		<?php 
		
		//don't need to create new users, just manage what we have:
		echo "<table class='table'>";
		echo "<tr><th>First Name</th><th>Last Name</th><th>Login</th><th>Email</th><th colspan='3'></th></tr>";
		
		foreach ($customers as $customer) {
			if($customer->login != 'admin'){
				echo "<tr>";
				echo "<td>" . $customer->first . "</td>";
				echo "<td>" . $customer->last . "</td>";
				echo "<td>" . $customer->login . "</td>";
				echo "<td>" . $customer->email . "</td>";
		
				echo "<td>" . anchor("candystore/delete_customer/$customer->id",'<span id="button">Delete</span>',"onClick='return confirm(\"Do you really want to delete this customer?\");'") . "</td>";
				echo "<td>" . anchor("candystore/readCustomerInfo/$customer->id",'<span id="button">View</span>') . "</td>";
				echo "<td>" . anchor("candystore/orderManager/$customer->id", '<span id="button">Order Management</span>') . "</td>";
		
				echo "</tr>";
			}
		}
		echo "</table>";
		
		
		
		?>
		
	</div>
	
	<div id="bottom">
		<a href='<?php echo base_url()."candystore/logout";?>' ><div id="button">Logout</div></a>
	</div>
<?php include('inc/footer.php') ?>