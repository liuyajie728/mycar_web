<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/* User */
	$route['login'] = 'user/login';
	$route['register'] = 'user/login';
	$route['logout'] = 'user/logout';
	$route['user/edit/(:any)'] = 'user/edit/$1';
	$route['user/(:any)'] = 'user/index/$1';
	$route['user'] = 'user/index';

	$route['default_controller'] = 'welcome';
	$route['404_override'] = '';
	$route['translate_uri_dashes'] = TRUE;
	
/* End of file routes.php */
/* Location: ./application/config/routes.php */