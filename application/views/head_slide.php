<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>E-Raffle Promo</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="<?php echo base_url(); ?>css/fb/bootstrap.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="<?php echo base_url(); ?>css/fb/styles.css" rel="stylesheet">
		<link rel="stylesheet" href='<?php echo base_url(); ?>css/eraffle.css'>
		<link rel="stylesheet" href='<?php echo base_url(); ?>css/sweetalert.css'>
		<link rel="stylesheet" href='<?php echo base_url(); ?>css/responsiveSlide/responsiveslides.css'>
		

	</head>
	<body>
<div class="wrapper">
    <div class="box">
        <div class="row row-offcanvas row-offcanvas-left">
                      
          
            <!-- sidebar -->

            <!-- /sidebar -->
          
            <!-- main right col -->
            <div class="column col-sm-10 col-xs-11" id="main" style='width:100%;'>
             

                                                                  
                        <div class='unslide'>
							<ul class="rslides" id='rslides'>
								<li><img src="<?php echo base_url(); ?>img/responsiveslide/0.jpg" style='width: 100%;' alt=""></li>
								<li><img src="<?php echo base_url(); ?>img/responsiveslide/00.jpg" style='width: 50%;display: block; margin-left: 24%;display: block;' alt=""></li>
								<li><img src="<?php echo base_url(); ?>img/responsiveslide/1.jpg" style='width: 35%; margin-left: 32%;' alt=""></li>
								<li><img src="<?php echo base_url(); ?>img/responsiveslide/2.jpg" style='width: 60%;width: 45%;margin-left: 22%;' alt=""></li>
								<li><img src="<?php echo base_url(); ?>img/responsiveslide/3.jpg" style='width: 45%;margin-left: 26%;' alt=""></li>
								<li><img src="<?php echo base_url(); ?>img/responsiveslide/4.jpg" style='width: 80%;margin-left: 10%;' alt=""></li>
								<li><img src="<?php echo base_url(); ?>img/responsiveslide/5.jpg" style='width: 40%; margin-left: 27%;' alt=""></li> 
							</ul>
						</div>
											
            </div>
            <!-- /main -->
          
        </div>
    </div>
</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>js/fb/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>js/sweetalert.min.js"></script>
		<script src="<?php echo base_url(); ?>js/plugins/responsiveSlide/responsiveslides.min.js"></script>
		<script type='text/javascript'> $(".rslides").responsiveSlides({
	  auto: true,             // Boolean: Animate automatically, true or false
	  speed: 500,            // Integer: Speed of the transition, in milliseconds
	  timeout: 3000,          // Integer: Time between slide transitions, in milliseconds
	  width: '80%',
	  height: 450,
	  pager: false,           // Boolean: Show pager, true or false
	  nav: false,             // Boolean: Show navigation, true or false
	  random: false,          // Boolean: Randomize the order of the slides, true or false
	  pause: false,           // Boolean: Pause on hover, true or false
	  pauseControls: true,    // Boolean: Pause when hovering controls, true or false
	  prevText: "Previous",   // String: Text for the "previous" button
	  nextText: "Next",       // String: Text for the "next" button
	  maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
	  navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
	  manualControls: "",     // Selector: Declare custom pager navigation
	  namespace: "rslides",   // String: Change the default namespace used
	  before: function(){},   // Function: Before callback
	  after: function(){}     // Function: After callback
	});
	</script>
		<script src="<?php echo base_url(); ?>js/fb/scripts.js"></script>

	</body>
</html>