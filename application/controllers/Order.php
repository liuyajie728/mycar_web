<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	* Order Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Order extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();

			// Redirect to login page if not logged in.
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
		}

		/**
		* View consume order list or single order.
		*
		* @since always
		* @param int $order_id
		* @return array Consume order contents.
		*/
		public function index($order_id = NULL)
		{
			$data['type'] = 'consume';
			if ($order_id != NULL):
				$params['order_id'] = $order_id;
			endif;
			$params['user_id'] = $this->session->userdata('user_id');

			$url = api_url('order');
		    $result = $this->curl->go($url, $params, 'array');

			if ($order_id === NULL): // 若未传入order_id，生成订单列表页并设置相应class
				$data['title'] = '消费账单';
				$data['class'] = 'order order-index';
				$this->load->view('templates/header', $data);
			    $data['orders'] = $result['content'];
				$this->load->view('order/index', $data);

			else: // 若传入order_id，生成订单详情页并设置相应class
				$data['title'] = '消费详情';
				$data['class'] = 'order order-detail';
				$this->load->view('templates/header', $data);
			    $data['order'] = $result['content'][0];
				$this->load->view('order/detail', $data);

			endif;
			$this->load->view('templates/footer', $data);
		}
		
		/**
		* View recharge order list or single order.
		*
		* @since always
		* @param int $order_id
		* @return array Recharge order contents.
		*/
		public function index_recharge($order_id = NULL)
		{
			$data['type'] = 'recharge';
			if ($order_id != NULL):
				$params['order_id'] = $order_id;
			endif;
			$params['user_id'] = $this->session->userdata('user_id');

			$url = api_url('order/recharge');
		    $result = $this->curl->go($url, $params, 'array');
			
			if ($order_id === NULL): // 若未传入order_id，生成订单列表页并设置相应class
				$data['title'] = '充值账单';
				$data['class'] = 'order order-index';
				$this->load->view('templates/header', $data);
			    $data['orders'] = $result['content'];
				$this->load->view('order/index', $data);

			else: // 若传入order_id，生成订单详情页并设置相应class
				$data['title'] = '充值详情';
				$data['class'] = 'order order-detail';
				$this->load->view('templates/header', $data);
			    $data['order'] = $result['content'][0];
				$this->load->view('order/detail', $data);

			endif;
			$this->load->view('templates/footer', $data);
		}
		
		/**
		* Supply user info to create order on remote server.
		*
		* @since always
		* @param array $params All datas that should be sent to API server.
		* @return array $result Order creating results.
		*/
		public function create($params)
		{
			// Automaticly generate api url according to $order_type.
			$url = api_url('order/create');
			$result = $this->curl->go($url, $params, 'array');
			return $result;
		}

		/**
		* Consume order
		*
		* @since always
		* @param int $station_id
		* @param int $_SESSION['user_id'] (NOTICE: CodeIgniter3 Session, NOT native PHP5 session)
		* @param int $_POST['refuel_cost']
		* @param int $_POST['shopping_cost']
		* @return void
		*/
		public function consume($station_id)
		{
			$data['title'] = '消费订单';
			$data['class'] = 'order order-consume order-create';

			$this->form_validation->set_rules('station_id', '加油站ID', 'trim|required');
			$this->form_validation->set_rules('refuel_cost', '加油/加气/充电金额', 'trim|numeric|greater_than[0]|required');
			$this->form_validation->set_rules('shopping_cost', '其它消费金额', 'trim|numeric|greater_than_equal_to[0]|required');

			if($this->form_validation->run() === FALSE):
				$data['station_id'] = $station_id;
				$this->load->view('templates/header', $data);
				$this->load->view('order/consume', $data);
				$this->load->view('templates/footer', $data);

			else:
				$params['user_id'] = $this->session->userdata('user_id');
				$params['station_id'] = $this->input->post('station_id');
				$params['refuel_cost'] = $this->input->post('refuel_cost');
				$params['shopping_cost'] = $this->input->post('shopping_cost');
				// 创建消费类型订单
				$params['type'] = 'consume';
				$order = $this->create($params);
				
				// 若订单创建成功，则跳转到支付页面（url形式传递order_id）
				if ($order['status'] == 200):
					$order = $order['content'];
				// 若订单创建不成功，则重新载入本页面
				else:
					echo $order_status['content'];
					
				endif;

			endif;
		}

		/**
		* Recharge order
		*
		* @since always
		* @param int $_SESSION['user_id'] (NOTICE: CodeIgniter3 Session, NOT native PHP5 session)
		* @param int $_POST['amount']
		* @return void
		*/
		public function recharge()
		{
			$data['title'] = '充值订单';
			$data['class'] = 'order order-recharge order-create';
			
			$this->form_validation->set_rules('amount', '充值金额', 'trim|is_natural_no_zero|required');

			if($this->form_validation->run() === FALSE):
				$this->load->view('templates/header', $data);
				$this->load->view('order/recharge', $data);
				$this->load->view('templates/footer', $data);

			else:
				$params['user_id'] = $this->session->userdata('user_id');
				$params['amount'] = $this->input->post('amount');
				// 创建充值类型订单
				$params['type'] = 'recharge';
				$order = $this->create($params);

				// 若订单创建成功，则跳转到微信支付页面（url形式传递total_fee、order_id）
				if ($order['status'] == 200):
					$order = $order['content'];
					$payment_url = base_url('wepay/demo/js_api_call.php?total_fee='. $order['total']. '&order_id='.$order['order_id']);
					//var_dump($payment_url);
					redirect($payment_url);
				// 若订单创建不成功，则重新载入本页面
				else:
					$this->load->view('templates/header', $data);
					$this->load->view('order/recharge', $data);
					$this->load->view('templates/footer', $data);
				endif;
				
			endif;
		}
	}