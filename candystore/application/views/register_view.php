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
		<p>Please, insert your data bellow to register.</p>
	
		<?php 
		
		echo form_open('candystore/register_validation');
		
		echo validation_errors();
		
		echo "<p>First Name: ";
		echo form_input('first');
		echo "</p>";
		
		echo "<p>Last Name: ";
		echo form_input('last');
		echo "</p>";

		echo "<p>E-mail: ";
		echo form_input('email');
		echo "</p>";

		echo "<p>Login: ";
		echo form_input('login');
		echo "</p>";
		
		echo "<p>Password ";
		echo form_password('password');
		echo "</p>";
		
		echo "<p>";
		echo form_submit('register_submit', 'Register');
		echo "</p>";
		
		echo form_close();
		
		?>
		
		</div>
	

</body>
</html>