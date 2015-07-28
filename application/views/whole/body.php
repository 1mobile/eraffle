    <body class='skin-red'>
        <?php if(!isset($noNavbar)): ?>
            <header class="header">
                <a href="<?php echo base_url().'cashier'; ?>" class="logo">
                    <img src = '<?php echo base_url(); ?>img/SWEETBYTESBANNERFB.jpg' style="width:100%;height:100%">
                </a>

            </header>
        <?php endif; ?>
        <div class="wrapper cashier-wrapper row-offcanvas row-offcanvas-left">
		
		<h3> <?php echo $status; ?></h3>
		<p><?php echo  $confirm; ?></p>
        <?php 
            if(isset($code))
                echo $code; 
        ?>
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