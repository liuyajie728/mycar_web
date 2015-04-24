<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/* Order */
	$route['order/create/consume/(:any)'] = 'order/consume/$1';
	$route['order/create/recharge'] = 'order/recharge';
	$route['order/confirm'] = 'order/confirm';
	$route['order/(:any)'] = 'order/index/$1';
	$route['order'] = 'order/index';
	
	/* Payment */
	$route['payment/create'] = 'payment/create';
	$route['payment/confirm'] = 'payment/confirm';
	$route['payment'] = 'payment/index';

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
	$route['user'] = 'user/index';
	
	/* Home Page */
	$route['home'] = 'home/index';

/**
* Stop Edit From Here
*
* @since always
*/
	/* Default Routes */
	$route['default_controller'] = 'home';
	$route['404_override'] = '';
	$route['translate_uri_dashes'] = TRUE;
	
/* End of file routes.php */
/* Location: ./application/config/routes.php */