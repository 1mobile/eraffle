<style>
body{
 background-color: #3C247F;
}	
.form-style-6 {
    font : 95% Arial, Helvetica, sans-serif;
    max-width : 700px;
    margin : 10px auto;
    padding : 16px;
    background : #fff;
}

.form-style-6 h2 {
    padding : 20px 0;
    font-size : 140%;
    font-weight : 300;
    text-align : center;
    color : #000;
    margin : -16px -16px 16px -16px;
}

.form-style-6 input[type="text"],
.form-style-6 input[type="date"],
.form-style-6 input[type="datetime"],
.form-style-6 input[type="email"],
.form-style-6 input[type="number"],
.form-style-6 input[type="search"],
.form-style-6 input[type="time"],
.form-style-6 input[type="url"],
.form-style-6 textarea,
.form-style-6 select {
    -webkit-transition : all 0.30s ease-in-out;
    -moz-transition : all 0.30s ease-in-out;
    -ms-transition : all 0.30s ease-in-out;
    -o-transition : all 0.30s ease-in-out;
    outline : none;
    box-sizing : border-box;
    -webkit-box-sizing : border-box;
    -moz-box-sizing : border-box;
    width : 100%;
    background : #fff;
    margin-bottom : 4%;
    border : 1px solid #ccc;
    padding : 3%;
    color : #555;
    font : 95% Arial, Helvetica, sans-serif;
}

.form-style-6 input[type="text"]:focus,
.form-style-6 input[type="date"]:focus,
.form-style-6 input[type="datetime"]:focus,
.form-style-6 input[type="email"]:focus,
.form-style-6 input[type="number"]:focus,
.form-style-6 input[type="search"]:focus,
.form-style-6 input[type="time"]:focus,
.form-style-6 input[type="url"]:focus,
.form-style-6 textarea:focus,
.form-style-6 select:focus {
    box-shadow : 0 0 5px #133783;
    padding : 3%;
    border : 1px solid #133783;
}

.form-style-6 input[type="submit"],
.form-style-6 input[type="button"],
.form-style-6 button[type="submit"] {
    box-sizing : border-box;
    -webkit-box-sizing : border-box;
    -moz-box-sizing : border-box;
    width : 100%;
    padding : 3%;
    background : #3a5795;
    border-bottom : 1px solid #133783;
    border-top-style : none;
    border-right-style : none;
    border-left-style : none;
    color : #fff;
}

.form-style-6 input[type="submit"]:hover,
.form-style-6 input[type="button"]:hover,.form-style-6 button[type="submit"]:hover {
    background : #B70B0D;
}
</style>

	<body class='skin-red'>
		<div class = "form-style-6">
        <?php if(!isset($noNavbar)): ?>
            <header class="header">
                <a href="<?php echo base_url().'cashier'; ?>" class="logo">
                    <img src = '<?php echo base_url(); ?>img/chocologo.png' style="width: 60%; height: auto; margin-left: auto;margin-right: auto;display: block;">
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