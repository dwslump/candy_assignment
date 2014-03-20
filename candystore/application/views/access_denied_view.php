<?php include('inc/header.php') ?>
	<div id="body">
		<h1>ACCESS DENIED!!!</h1>
		<img id="denied" src='<?php echo base_url() . "images/denied.jpg"; ?>'>
		<p>I'm sorry, but you don't have permission to access this.</p>
		
		<?php
			echo "<p>" . anchor('candystore/index','<span id="button">Let\'s go to index eh?</span>') . "</p>";
		?>
		
	</div>
<?php include('inc/footer.php') ?>