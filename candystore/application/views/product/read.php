<?php include('inc/header.php'); ?>
<h2>Product Entry</h2>

<style>
img {
	width: initial;
}
</style>

<?php 
	echo "<p>" . anchor('candystore/index','<span id="button">Back</span>') . "</p>";
	echo '<div class="login">';
	echo "<p><img style='width: 400px;' " . "src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px'/></p>";
	echo "<table class='details'>";
	echo "<tr><td>ID</td><td>" . $product->id . "</td></tr>";
	echo "<tr><td>Name</td><td>" . $product->name . "</td></tr>";
	echo "<tr><td>Description</td><td>" . $product->description . "</td></tr>";
	echo "<tr><td>Price</td><td>" . $product->price . "</td></tr>";
	echo "</table>";
	echo "</div>";
?>	

<?php include('inc/footer.php') ?>