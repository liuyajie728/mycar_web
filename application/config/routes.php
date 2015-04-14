<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/* Station */
	$route['station/(:any)'] = 'station/index/$1';
	$route['station'] = 'station/index';

	/* Sms */
	$route['sms/send'] = 'sms/send';

	/* User */
	$route['login'] = 'user/login';
	$route['register'] = 'user/login';
	$route['logout'] = 'user/logout';
	$route['user/edit/(:any)'] = 'user/edit/$1';
	$route['user/(:any)'] = 'user/index/$1';
	$route['user'] = 'user/index';
	
	/* Home Page */
	$route['home'] = 'home/index';

	$route['default_controller'] = 'home';
	$route['404_override'] = '';
	$route['translate_uri_dashes'] = TRUE;
	
/* End of file routes.php */
/* Location: ./application/config/routes.php */