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
	
		<h2>Product Manager</h2>
		
		<p>You can manage all products bellow:</p>	
	
		<?php 
		echo "<p>" . anchor('candystore/newForm','Add New') . "</p>";
 	  
		echo "<table>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				
			echo "<td>" . anchor("candystore/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
			echo "<td>" . anchor("candystore/editForm/$product->id",'Edit') . "</td>";
			echo "<td>" . anchor("candystore/read/$product->id",'View') . "</td>";
				
			echo "</tr>";
		}
		echo "<table>";
		
		?>
		
		<h2>Customer Manager</h2>
		
		<p>You can manage all the customers bellow:</p>
		
		<?php 
		
		//don't need to create new users, just manage what we have:
		echo "<table>";
		echo "<tr><th>First Name</th><th>Last Name</th><th>Login</th><th>Email</th></tr>";
		
		foreach ($customers as $customer) {
			if($customer->login != 'admin'){
				echo "<tr>";
				echo "<td>" . $customer->first . "</td>";
				echo "<td>" . $customer->last . "</td>";
				echo "<td>" . $customer->login . "</td>";
				echo "<td>" . $customer->email . "</td>";
		
				echo "<td>" . anchor("candystore/delete_customer/$customer->id",'Delete',"onClick='return confirm(\"Do you really want to delete this customer?\");'") . "</td>";
				echo "<td>" . anchor("candystore/readCustomerInfo/$customer->id",'View') . "</td>";
				echo "<td>" . anchor("candystore/orderManager/$customer->id", 'Order Management') . "</td>";
		
				echo "</tr>";
			}
		}
		echo "<table>";
		
		
		
		?>
		
		</div>
		
		<div id="bottom">
			<a href='<?php echo base_url()."candystore/logout";?>' >Logout</a>
		</div>
	

</body>
</html>