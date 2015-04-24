<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Order extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();

			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
		}

		public function index($order_id = NULL)
		{
			if ($order_id != NULL):
				$params['order_id'] = $order_id;
			endif;
			$params['user_id'] = $this->session->userdata('user_id');

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
			
			if ($order_id === NULL): // 若未传入order_id，生成订单列表页并设置相应class
				$data['title'] = '订单列表';
				$data['class'] = 'order order-index';
				$this->load->view('templates/header', $data);
			    $data['orders'] = $result['content'];
				$this->load->view('order/index', $data);

			else: // 若传入order_id，生成订单详情页并设置相应class
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
		* @param array $params All datas that should be sent to API server.
		* @param string $order_type Order type, allows either 'consume' or 'recharge', default to 'consume'
		* @return json Order creating results.
		*/
		public function create($params, $order_type = 'consume')
		{
			// Automaticly generate api url according to $order_type.
			$url = api_url('order/create/'. $order_type);

		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, count($params));
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		    // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
		    // 运行cURL，请求API
		    $result = json_decode(curl_exec($curl), TRUE);
		    // 关闭URL请求
		    curl_close($curl);
			return $result['status'];
		}
		
		// 消费订单
		public function consume($station_id)
		{
			$data['title'] = '消费订单';
			$data['class'] = 'order order-consume order-create';

			$this->form_validation->set_rules('station_id', '加油站ID', 'trim|required');
			$this->form_validation->set_rules('refuel_amount', '加油/加气/充电金额', 'trim|required');
			$this->form_validation->set_rules('shopping_amount', '其它消费金额', 'trim|required');

			if($this->form_validation->run() === FALSE):
				$data['station_id'] = $station_id;
				$this->load->view('templates/header', $data);
				$this->load->view('order/consume', $data);
				$this->load->view('templates/footer', $data);

			else:
				$params['user_id'] = $this->session->userdata('user_id');
				$params['station_id'] = $this->input->post('station_id');
				$params['refuel_amount'] = $this->input->post('refuel_amount');
				$params['shopping_amount'] = $this->input->post('shopping_amount');
				// 创建消费类型订单
				//$order_status = $this->create($params);
				
				// 若订单创建成功，则跳转到支付页面（url形式传递order_id）
				
				// 若订单创建不成功，则重新载入本页面
			endif;
			$this->output->enable_profiler(TRUE);
		}

		// 充值订单
		public function recharge()
		{
			$data['title'] = '充值订单';
			$data['class'] = 'order order-recharge order-create';
			
			$this->form_validation->set_rules('amount', '充值金额', 'trim|required');
			
			if($this->form_validation->run() === FALSE):
				$this->load->view('templates/header', $data);
				$this->load->view('order/recharge', $data);
				$this->load->view('templates/footer', $data);

			else:
				$params['user_id'] = $this->session->userdata('user_id');
				$params['amount'] = $this->input->post('amount');
				// 创建充值类型订单
				//$order_status = $this->create($params, 'recharge');
				
				// 若订单创建成功，则跳转到支付页面（url形式传递order_id）
			
				// 若订单创建不成功，则重新载入本页面
			endif;
			$this->output->enable_profiler(TRUE);
		}
	}