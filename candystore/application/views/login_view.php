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
		<p>To have access to the Candystore you must be logged in.</p>
	
		<?php 
		
		echo form_open('candystore/login_validation');
		
		echo validation_errors();
		
		echo "<p>Login ";
		echo form_input('login');
		echo "</p>";

		echo "<p>Password ";
		echo form_password('password');
		echo "</p>";
		
		echo "<p>";
		echo form_submit('login_submit', 'Login');
		echo "</p>";
		
		echo form_close();
		
		?>
		
	</div>

</body>
</html>