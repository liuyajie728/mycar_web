<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Payment extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
		}
		
		/**
		* Payment Code
		*
		* @since always
		* @return int Payment Code
		*/
		public function code()
		{
			$data['title'] = '付款码';
			$data['class'] = 'payment payment-code';

			// ! generate payment code
			$this->load->helper('string');
			//$code = random_string('numeric', 2).$this->session->userdata('user_id').random_string('numeric', 4);
			$code = random_string('numeric', 2).'1'.random_string('numeric', 4);
			$data['payment_code'] = $code;

			$this->load->view('templates/header', $data);
			$this->load->view('payment/code', $data);
			$this->load->view('templates/footer', $data);
		}

		public function index($order_id = NULL)
		{
			if ($order_id === NULL):
				// 未设计逻辑，待补充
			else:
				$params['order_id'] = $order_id;
			endif;
			$params['user_id'] = $this->input->cookie('user_id');
			
			$url = api_url('order');
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
			$this->load->view('templates/footer', $data);
		}
		
		/**
		* Supply user_info to create order on remote server.
		*
		* @since always
		* @param $_POST['user_id'] Buyer user ID
		* @param $_POST['amount'] Order raw amount, no coupon or other deduction counted in.
		* @return json Order creating results.
		*/
		public function create()
		{
			if($this->input->is_ajax_request()):
				$params['user_id'] = $this->input->post('user_id');

				$url = api_url('order/create');
			    $curl = curl_init();
			    curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_POST, count($params));
				curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
			    // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
			    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
			    // 运行cURL，请求API
			    $result = json_decode(curl_exec($curl));
			    // 关闭URL请求
			    curl_close($curl);
				echo $result;

			endif;
		}
	}