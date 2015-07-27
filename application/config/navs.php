<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//////////////////////////////////////////////////
/// SIDE BAR LINKS                            ///
////////////////////////////////////////////////

$nav = array();
$nav['dashboard'] = array('title'=>'<i class="fa fa-tachometer"></i> Dashboard','path'=>'dashboard','exclude'=>0);
$nav['config'] = array('title'=>'<i class="fa fa-building-o"></i> <span>Company</span>','path'=>'setup','exclude'=>0);
///ADMIN CONTROL////////////////////////////////
// $nav['setup'] = array('title'=>'<i class="fa fa-building-o"></i> Setup','path'=>'setup','exclude'=>0);
// $nav['setup'] = array('title'=>'<i class="fa fa-building-o"></i> Setup','path'=>'setup','exclude'=>0);
// $nav['profile'] = array('title'=>'<i class="fa fa-user"></i> <span>Profile</span>','path'=>'user/profile','exclude'=>1);
	$controlSettings['user'] = array('title'=>'Users','path'=>'user','exclude'=>0);
	$controlSettings['roles'] = array('title'=>'Roles','path'=>'admin/roles','exclude'=>0);
$nav['control'] = array('title'=>'<i class="fa fa-gears"></i> <span>Admin Control</span>','path'=>$controlSettings,'exclude'=>0);
// $nav['messages'] = array('title'=>'<i class="fa fa-envelope-o"></i> <span>Messages</span>','path'=>'messages','exclude'=>1);
// $nav['messages'] = array('title'=>'<i class="fa fa-envelope-o"></i> <span>Messages</span>','path'=>'messages','exclude'=>1);
// $nav['preferences'] = array('title'=>'<i class="fa fa-wrench"></i> <span>Preferences</span>','path'=>'preference','exclude'=>1);
///LOGOUT///////////////////////////////////////
$nav['logout'] = array('title'=>'<i class="fa fa-sign-out"></i> <span>Logout</span>','path'=>'site/go_logout','exclude'=>1);
$config['sideNav'] = $nav;
