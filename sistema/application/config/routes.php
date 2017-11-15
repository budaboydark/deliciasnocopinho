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

$route['default_controller'] 		= "welcome";
$route["(.*)-produto-(:num).html"] 	= "produto/detail/$2";

/* samples
$route['default_controller'] 		= "home";
$route["(.*)-ref-(:num).html"] 		= "realty/detail/$2";
$route["(.*)-busca-venda.html"] 	= "realty/search/$1-busca-venda.html";
$route["(.*)-busca-locacao.html"] 	= "realty/search/$1-busca-locacao.html";
$route["(.*)lancamentos.html"] 		= "realty/search/lancamentos.html";
$route['corretor/(:any)'] 			= 'broker/$1'; */

/* ADMIN ROUTES */
$route["admin"]			  		= "admin_dashboard";
$route["admin/([a-zA-Z0-9/]+)"] = "admin_$1";

/* CONTRIBUINTE ROUTES */
$route["contribuinte"]			  		= "contribuinte_dashboard";
$route["contribuinte/([a-zA-Z0-9/]+)"]  = "contribuinte_$1";

//$route['404_override'] = 'error404';

/* End of file routes.php */
/* Location: ./application/config/routes.php */