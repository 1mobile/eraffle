<!DOCTYPE HTML>
<html>
<head>
	<title>E-Raffle Promo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href='<?php echo base_url(); ?>css/eraffle.css'>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="form-style-6">
			<img src='<?php echo base_url(); ?>img/sweetbyteFB.jpg' class= 'logo' height='194' width='303'>
			<hr>
			<h1> Raffle Entry</h1>
			<form method="POST" action="/eraffle/codes	/redeem">
			<select name="area" required>
			   <?php 
					foreach($areas as $area){ 
						$area_name = $area->name;
						$area_loc = $area->area;
						echo "<option name='area_opt' value= '".$area->id."'> $area_name , $area_loc </option>";
					} 
				?>
			</select>
			<input type="text" name="name" placeholder="Name" required />
			<input type="email" name="emailaddress" placeholder="Email Address" required />
			<input type="text" name="rafflecode5" placeholder="Raffle Code" required />
			<input type="submit" value="Send" />
			</form>
		</div>
	</div>
</div>
</body>
</html>