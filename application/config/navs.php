<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//////////////////////////////////////////////////
/// SIDE BAR LINKS                            ///
////////////////////////////////////////////////

$nav = array();
$nav['dashboard'] = array('title'=>'<i class="fa fa-tachometer"></i> Dashboard','path'=>'dashboard','exclude'=>0);


	$raffle['rfdraw'] = array('title'=>'Draw','path'=>'raffle','exclude'=>0);
	$raffle['rflist'] = array('title'=>'List','path'=>'raffle/raffle_list','exclude'=>0);
$nav['raffle'] = array('title'=>'<i class="fa fa-circle-thin"></i> Raffle','path'=>$raffle,'exclude'=>0);
// 	$transNavs['redeem'] = array('title'=>'Redeem','path'=>'trans/redeem','exclude'=>0);
// 	$transNavs['redeem_list'] = array('title'=>'Redeems List','path'=>'trans/redeem_list','exclude'=>0);
// $nav['trans'] = array('title'=>'<i class="fa fa-random"></i> <span>Transactions</span>','path'=>$transNavs,'exclude'=>0);
$nav['trans'] = array('title'=>'<i class="fa fa-archive"></i> <span>Item Redeems</span>','path'=>'trans/item_redeems','exclude'=>0);
$nav['codes'] = array('title'=>'<i class="fa fa-tags"></i> <span>Codes</span>','path'=>'codes','exclude'=>0);
$nav['points'] = array('title'=>'<i class="fa fa-dot-circle-o"></i> <span>Email Points</span>','path'=>'points','exclude'=>0);
	$setup['items'] = array('title'=>'Items','path'=>'items','exclude'=>0);
$nav['maintenance'] = array('title'=>'<i class="fa fa-archive"></i> <span>Maintenance</span>','path'=>$setup,'exclude'=>0);
	$config['general'] = array('title'=>'General','path'=>'settings','exclude'=>0);
	$config['company'] = array('title'=>'Company','path'=>'setup','exclude'=>0);
$nav['configuration'] = array('title'=>'<i class="fa fa-gears"></i> <span>Settings</span>','path'=>$config,'exclude'=>0);
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
