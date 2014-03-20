<?php include('inc/header.php'); ?>
	<div id="body">
		<h1>Welcome to Candy Store &reg; Shop Center</h1>
		<h3>To have access to the Candystore you must be logged in.</h3>
		<div class="login">
			<?php 
			
			echo form_open('candystore/login_validation');
			
			echo validation_errors();
			
			echo "<p>Login <br>";
			echo form_input('login');
			echo "</p>";

			echo "<p>Password <br>";
			echo form_password('password');
			echo "</p>";
			
			echo "<p>";
			echo form_submit('login_submit', 'Login');
			echo "</p>";
			
			echo form_close();
			
			?>
		
		</div>
	<sub>Not a member? <a href= '<?php echo base_url()."candystore/register_customer" ?>'><span>Register</span></a></sub>
	
	</div>
<?php include('inc/footer.php'); ?>