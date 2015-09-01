	<body class='skin-red'>
		<div class = "form-style-6">
        <?php if(!isset($noNavbar)): ?>
            <header class="header">
                <a href="<?php echo base_url().'cashier'; ?>" class="logo">
                    <img src = '<?php echo base_url(); ?>img/sweetbyteFB.jpg' class= 'logo' style="width: 75%!important; height: auto; margin-left: auto;margin-right: auto;display: block;">
                </a>

            </header>
        <?php endif; ?>
        <div class="wrapper cashier-wrapper row-offcanvas row-offcanvas-left" style='text-align:center;'>
		<hr style='border:2px solid #F19222;'>
		<h3 style='font:25px sans-serif;'> <?php echo $status; ?></h3>
		<p style='font: 14px sans-serif;'><?php echo  $confirm; ?></p>
        <?php 
            if(isset($code))
                echo $code; 
        ?>
        </div>
		 </div>
    </body>
    <?php
        if(isset($js))
            echo $js;
        ?> 
        <?php 
            if(isset($add_js)){
                if(is_array($add_js)){
                    foreach ($add_js as $path) {
                        echo '<script src="'.base_url().$path.'" type="text/javascript"  language="JavaScript"></script>';
                    }
                }
                else
                     echo '<script src="'.base_url().$add_js.'" type="text/javascript"  language="JavaScript"></script>';
            }
        ?> 