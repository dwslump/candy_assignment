<?php include('inc/header.php'); ?>
	<div id="body">
		<h1>Registration Succeded!</h1>
		<p>Let's have fun and buy some candy! =D</p>
		<p>Click bellow to login</p>
		
		<?php
			echo "<p><span id='button'>" . anchor('candystore/index','Start buying candy!') . "</span></p>";
		?>
		
		</div>
<?php include('inc/footer.php'); ?>