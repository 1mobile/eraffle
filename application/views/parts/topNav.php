		<header class="header" >
            <a href="<?php echo base_url()."dashboard"; ?>" class="logo">
              <img src="<?php echo base_url(); ?>img/codetojoy_mini.jpg" width='45'>  <?php echo $logo; ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Tasks: style can be found in dropdown.less -->
                        <!-- <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i> -->
                                <?php 
                                    // if(isset($task) && count($task) > 0){
                                    //     echo '
                                    //         <span class="label label-danger">
                                    //         '.count($task).'
                                    //         </span>
                                    //     ';
                                    // }    
                                ?>
                            <!-- </a> -->
                            <!-- <ul class="dropdown-menu"> -->
                            <?php
                                // if(isset($task) && count($task) > 0){
                                //     echo '<li class="header">You have '.count($task).' task</li>';   
                                //     echo '<li>';   
                                //     echo '<ul class="menu">';   
                                //         $ctr = 0;
                                //         foreach ($task as $work_id => $opt) {
                                //             if($ctr < 4){
                                //                 echo '<li>';   
                                //                 // '.base_url().'work_order/view/'.$work_id.'
                                //                     echo '<a  class="not-task-view-btn" href="#" rata-title="Work Order #'.$opt['ref'].'">';
                                //                         echo '
                                //                             <h3>
                                //                                 '.$opt['name'].'
                                //                                 <small class="pull-right">'.$opt['percent'].'%</small>
                                //                             </h3>
                                //                             <div class="progress xs">
                                //                                 <div class="progress-bar progress-bar-aqua" style="width: '.$opt['percent'].'%" role="progressbar" aria-valuenow="'.$opt['percent'].'" aria-valuemin="0" aria-valuemax="100">
                                //                                     <span class="sr-only">'.$opt['percent'].'% Complete</span>
                                //                                 </div>
                                //                             </div>
                                //                         ';
                                //                     echo '</a>';
                                //                echo '</li>';  
                                //            }
                                //            $ctr++;
                                //         } 
                                //     echo '</ul>';   
                                //     echo '</li>';   
                                // }
                                // else{
                                //     echo '<li class="header">You have no task</li>';    
                                // }
                                // echo '
                                //     <li class="footer">
                                //         <a href="#">View all tasks</a>
                                //     </li>
                                // ';
                            ?>
                           <!--  </ul>
                        </li> -->

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-white">
                                    <img src="<?php echo $user_img; ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php
                                            if(isset($user['full_name']))
                                                echo $user['full_name'];
                                        ?>
                                        <small>
                                         <?php
                                            if(isset($user['role']))
                                                echo $user['role'];
                                        ?>
                                        </small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!-- <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Preferences</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li> -->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?Php echo base_url()."user/profile" ?>" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-left" style="margin-left:20px;">
                                        <a href="<?Php echo base_url()."user/messages" ?>" class="btn btn-default btn-flat">Messages</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?Php echo base_url()."site/go_logout" ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">