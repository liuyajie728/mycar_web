<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/* Order */
	$route['order/create/consume/(:any)'] = 'order/consume/$1';
	$route['order/create/recharge'] = 'order/recharge';
	$route['order/recharge/(:any)'] = 'order/index_recharge/$1'; // 查询特定充值订单
	$route['order/recharge'] = 'order/index_recharge';
	$route['order/consume/(:any)'] = 'order/index/$1';
	$route['order/(:any)'] = 'order/index/$1'; // 查询特定消费订单
	$route['order'] = 'order/index';
	
	/* Comment */
	$route['comment/create/(:any)'] = 'comment/create/$1'; // 评价订单
	$route['comment/append/(:any)'] = 'comment/append/$1'; // 追加评价订单

	/* Station */
	$route['station/(:any)'] = 'station/index/$1';

	/* User */
	$route['login'] = 'user/login';
	$route['logout'] = 'user/logout';
	$route['user/edit/(:any)'] = 'user/edit/$1';
	$route['user'] = 'user/index';
	
	/* Home Page */
	$route['home/(:any)/(:any)'] = 'home/index/$1/$2';
	$route['home'] = 'home/index';
	
	/* Wechat API */
	$route['wechat'] = 'wechat/index';
	
	/* Sms */
	$route['sms/send'] = 'sms/send';

/**
* Stop Edit From Here
*
* @since always
*/
	/* Default Routes */
	$route['default_controller'] = 'home/index';
	$route['404_override'] = '';
	$route['translate_uri_dashes'] = TRUE;
	
/* End of file routes.php */
/* Location: ./application/config/routes.php */