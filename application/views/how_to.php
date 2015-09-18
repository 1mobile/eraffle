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
                
                <!-- top nav -->
              	<div class="navbar navbar-blue navbar-static-top">  
                    <div class="navbar-header">
                      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle</span>
                        <span class="icon-bar"></span>
          				<span class="icon-bar"></span>
          				<span class="icon-bar"></span>
                      </button>
                      <a href="/" class="navbar-brand br-logo">ba</a>
                  	</div>
					<nav class="collapse navbar-collapse" role="navigation">
                  	                   <ul class="nav navbar-nav">
                      <li>
                        <a href="/eraffle/codes/raffle_form" role="button" ><i class="glyphicon glyphicon-plus"></i> Add Entry</a>
                      </li>
                      <li>
                        <a href="/eraffle/redeem"><span class="badge">Redeem Prize</span></a>
                      </li>
					  <li>
                        <a href="#">How to Claim Prize</a>
                      </li>
					  <li>
                        <a href="/eraffle/codes/mechanics">Promo Mechanics</a>
                      </li>
                    </ul>
					</nav>
                </div>
                <!-- /top nav -->
              
                <div class="padding">
                    <div class="full col-sm-9">
                      
                        <!-- content -->                      
                      	<div class="row">
                          
                   
                          
                          <!-- main col right -->
                                <div class="panel panel-default"> 
                                  		<div class="form-style-6">
											<!--<img src='<?php echo base_url(); ?>img/sweetbyteFB.jpg' class= 'logo' height='194' width='303'>-->
											
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
											<hr>
											<h1>How to claim your prize</h1>
											<p>Stand by for more infos....</p>
										</div>
                                </div>

                       </div><!--/row-->
                      
                       
                    
                        
                      
                    </div><!-- /col-9 -->
                </div><!-- /padding -->
            </div>
            <!-- /main -->
          
        </div>
    </div>
</div>


<!--post modal-->
<div id="postModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			Update Status
      </div>
      <div class="modal-body">
          <form class="form center-block">
            <div class="form-group">
              <textarea class="form-control input-lg" autofocus="" placeholder="What do you want to share?"></textarea>
            </div>
          </form>
      </div>
      <div class="modal-footer">
          <div>
          <button class="btn btn-primary btn-sm" data-dismiss="modal" aria-hidden="true">Post</button>
            <ul class="pull-left list-inline"><li><a href=""><i class="glyphicon glyphicon-upload"></i></a></li><li><a href=""><i class="glyphicon glyphicon-camera"></i></a></li><li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
		  </div>	
      </div>
  </div>
  </div>
</div>
	<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>js/fb/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>js/fb/scripts.js"></script>
		<script src="<?php echo base_url(); ?>js/plugins/responsiveSlide/responsiveslides.min.js"></script>
		<script src="<?php echo base_url(); ?>js/plugins/responsiveSlide/read.js"></script>
	</body>
</html>