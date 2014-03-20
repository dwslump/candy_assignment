<?php 

?>
<!DOCTYPE html>
<html>
<head>
	<link href='http://fonts.googleapis.com/css?family=Gafata|Sofadi+One' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href='<?php echo base_url() . "css/normalize.css"; ?>' type-"text/css" media="screen"/>
	<link rel="stylesheet" href='<?php echo base_url() . "css/style.css"; ?>' type="text/css" media="screen"/>
	<title>Candy Store - Cheap n' Sweet Dreams</title>
</head>
<body>
	<div class="header">
		<img src='<?php echo base_url() . "images/banner.jpg"; ?>'>
		<a href="<?php echo base_url(); ?>"><div class="top_menu">
			<img src='<?php echo base_url() . "images/candy_logo.png"; ?>'>
			<span><p>Candy Store</p></span>
			<ul>
				<?php if(!isset($this->session->userdata['login'])){
					echo "<p>Transforming dreams true with affordable prices</p>";
				} else {
					echo "<p>Welcome back, <b>" . $this->session->userdata['login'] . "</b>!</p>";
					if(5 >= date('G') AND date('G') < 12){ echo "<p>Good Morning!</p>";}
					elseif(12 >= date('G') AND date('G') < 18){echo "<p>Good Afternoon!</p>";}
					else{echo "<p>Good Evening!</p>";};
				}; ?>
			</ul>			
		</div></a>
	</div>