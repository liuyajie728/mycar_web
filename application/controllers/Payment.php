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

		public function index($payment_id = NULL)
		{
			if ($payment_id === NULL):
				// 未设计逻辑，待补充
			else:
				$params['$payment_id'] = $payment_id;
			endif;
			$params['user_id'] = $this->session->userdata('user_id');
			
			$url = api_url('order');
		    $result = $this->curl->go($url, $params, 'array');
			
			if ($payment_id === NULL): // 若未传入payment_id，生成流水列表页并设置相应class
				$data['title'] = '流水列表';
				$data['class'] = 'payment payment-index';
				$this->load->view('templates/header', $data);
			    $data['payments'] = $result['content'];
				$this->load->view('payment/index', $data);
			else: // 若传入order_id，生成油站详情页并设置相应class
				$data['title'] = '流水详情';
				$data['class'] = 'payment payment-detail';
				$this->load->view('templates/header', $data);
			    $data['payment'] = $result['content'];
				$this->load->view('payment/detail', $data);
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
		public function create($order_id)
		{
			$data['title'] = '创建流水';
			$data['class'] = 'payment payment-create';
			
			$this->form_validation->set_rules('method', '支付方式', 'trim|required');

			if($this->form_validation->run() === FALSE):
				$data['order_id'] = $order_id;

				$this->load->view('templates/header', $data);
				$this->load->view('payment/create', $data);
				$this->load->view('templates/footer', $data);

			else:
				$params['order_id'] = $this->input->post('order_id');
				$params['method'] = $this->input->post('method');

				var_dump($params);
				$url = api_url('payment/create');
			    //echo $this->curl->go($url, $params);

			endif;
		}

		/**
		* Confirm payment status
		*
		* @since always
		* @param int $payment_id
		* @return json Payment confirmation status
		*/
		public function confirm($payment_id)
		{
			if($this->input->is_ajax_request()):
				$params['payment_id'] = $this->input->post('payment_id');
				
				$url = api_url('payment/confirm');
				echo $this->curl->go($url, $params);

			endif;
		}
	}