<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "core/dashboard";
$route['404_override'] = '';
$route['login'] = "site/login";
# RAFFLE #
	$route['codes'] = "eraffle/codes";
	$route['codes/(:any)'] = "eraffle/codes/$1";
	$route['redeem'] = "eraffle/redeem";
	$route['redeem/(:any)'] = "eraffle/redeem/$1";
	$route['points'] = "eraffle/points";
	$route['points/(:any)'] = "eraffle/points/$1";
	$route['items'] = "eraffle/items";
	$route['items/(:any)'] = "eraffle/items/$1";
	$route['trans'] = "eraffle/trans";
	$route['trans/(:any)'] = "eraffle/trans/$1";

# USER #
	$route['user'] = "core/user";
	$route['user/(:any)'] = "core/user/$1";

# ADMIN #
	$route['admin'] = "core/admin";
	$route['admin/(:any)'] = "core/admin/$1";

# WAGON #
	$route['setup'] = "core/setup";
	$route['setup/(:any)'] = "core/setup/$1";

# DASHBOARD #
	$route['dashboard'] = "core/dashboard";
	$route['dashboard/(:any)'] = "core/dashboard/$1";

# WAGON #
	$route['wagon'] = "core/wagon";
	$route['wagon/(:any)'] = "core/wagon/$1";

# WAGON #
	$route['loads'] = "core/loads";
	$route['loads/(:any)'] = "core/loads/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */