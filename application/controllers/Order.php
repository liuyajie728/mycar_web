<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Order extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function index($order_id = NULL)
		{
			if ($order_id === NULL):
				// 未完成，待补充
			else:
				$params['order_id'] = $order_id;
			endif;
			$params['user_id'] = $this->input->cookie('user_id');

			$url = 'http://www.key2all.cn/order';			
		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, count($params));
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		    // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
		    // 运行cURL，请求API
		    $result = json_decode(curl_exec($curl), TRUE); // 将json对象转换成关联数组
		    // 关闭URL请求
		    curl_close($curl);
			
			if ($order_id === NULL): // 若未传入order_id，生成油站列表页并设置相应class
				$data['title'] = '订单列表';
				$data['class'] = 'order order-index';
				$this->load->view('templates/header', $data);
			    $data['orders'] = $result['content'];
				$this->load->view('order/index', $data);
			else: // 若传入order_id，生成油站详情页并设置相应class
				$data['title'] = '订单详情';
				$data['class'] = 'order order-detail';
				$this->load->view('templates/header', $data);
			    $data['order'] = $result['content'];
				$this->load->view('order/detail', $data);
			endif;
			$this->load->view('templates/footer');
		}
	}