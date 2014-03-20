	<div class="brigadeiro" style="<?php if(isset($this->session->userdata['login'])){echo 'Display:none;';}; ?>">
			<span id="doodle" style="text-align: right; color: #FFF; margin-right: 15px;">doodle</span>
			<table><tr>
				<td><p>Brigadeiro (Portuguese for Brigadier; also known in some southern Brazilian states as negrinho, literally "blackie") is a simple Brazilian chocolate bonbon, created in the 1940s and named after Brigadier Eduardo Gomes, whose shape is reminiscent of that of some varieties of chocolate truffles. It is a very popular candy in Brazil and in Portugal and it is usually served as a dessert and at birthday parties.</p><a href="http://en.wikipedia.org/wiki/Brigadeiro"><b>Wikipedia</b></a></td>
				<td><img src='<?php echo base_url() . "images/brigadeiro.png"; ?>'></td>
			</tr></table>
	</div>
	<div class="footer"> <p>&copy;<?php echo date('Y'); ?> Candy Store</p> </div>
</body>
</html>