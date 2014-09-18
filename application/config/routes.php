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
$route['default_controller'] = 'pages/view';
$route['pages/create'] = 'pages/create';
$route['pages/(:any)'] = 'welcome/$1';
$route['pages'] = 'pages';
$route['pages/view'] = 'pages/view'; 
$route['pages/main_login'] = 'pages/main_login';
$route['(:any)'] = 'pages/view/$1';
$route['pages/req'] = 'pages/req';
$route['(:any)'] = 'pages/req/$1';
$route['pages/lottery_view'] = 'pages/lottery_view';
$route['(:any)'] = 'pages/lottery_view/$1';
$route['pages/app_open'] = 'pages/app_open';
$route['pages/app_close'] = 'pages/app_close';
$route['pages/lottery_run'] = 'pages/lottery_run';
$route['pages/view_list'] = 'pages/view_list';
$route['pages/lottery_create'] = 'pages/lottery_create';
$route['pages/load'] = 'pages/load';
$route['(:any)'] = 'pages/load/$1';
$route['pages/view_public'] = 'pages/view_public';
$route['pages/notifications'] = 'pages/notifications';
$route['pages/to_notify'] = 'pages/to_notify';
$route['pages/notified'] = 'pages/notified';
$route['pages/enrolled'] = 'pages/enrolled';
$route['pages/send_email'] = 'pages/send_email';
$route['pages/delete_noti'] = 'pages/delete_noti';
$route['pages/delete_list'] = 'pages/delete_list';

/* End of file routes.php */
/* Location: ./application/config/routes.php */