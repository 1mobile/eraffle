    <body>
        <!-- Automatic element centering using js -->
        <div class="center">            
            <?php 
                if(isset($code))
                    echo $code; 
            ?>
        </div><!-- /.center -->
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
        <script type="text/javascript">
            // $(function() {
            //     $(".center").center();
            //     $(window).resize(function() {
            //         $(".center").center();
            //     });
            // });
        </script>

    