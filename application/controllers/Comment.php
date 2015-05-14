<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	* Comment Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Comment extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();

			// Redirect to login page if not logged in.
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;
		}

		public function create($order_id)
		{
			$data['title'] = '订单评价';
			$data['class'] = 'comment comment-create';

			$this->form_validation->set_rules('order_id', '订单ID', 'trim|required');
			$this->form_validation->set_rules('station_id', '加油站ID', 'trim|required');
			$this->form_validation->set_rules('rate_oil', '能源质量', 'trim|numeric|greater_than_equal_to[0]|less_than_equal_to[100]|required');
			$this->form_validation->set_rules('rate_service', '服务评价', 'trim|numeric|greater_than_equal_to[0]|less_than_equal_to[100]|required');
			$this->form_validation->set_rules('content', '评论内容', 'trim');

			if($this->form_validation->run() === FALSE):
				$this->load->view('templates/header', $data);
				$this->load->view('comment/create', $data);
				$this->load->view('templates/footer', $data);

			else:
				$params['order_id'] = $this->input->post('order_id');
				$params['station_id'] = $this->input->post('station_id');
				$params['rate_oil'] = $this->input->post('rate_oil');
				$params['rate_service'] = $this->input->post('rate_service');
				$params['content'] = $this->input->post('content');

				$url = api_url('comment/create');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] == 200):
					echo '评论成功！';
				else:
					echo '评论失败，请重试！';
					$this->load->view('templates/header', $data);
					$this->load->view('comment/create', $data);
					$this->load->view('templates/footer', $data);
				endif;
			endif;
		}

		public function append($comment_id) // Causion here!!! Parameter must be $comment_id, NOT $order_id!!!
		{
			$data['title'] = '追加评价';
			$data['class'] = 'comment comment-append';
			
			$this->form_validation->set_rules('comment_id', '评论对象', 'trim|required');
			$this->form_validation->set_rules('append', '追加评论内容', 'trim|required');

			if($this->form_validation->run() === FALSE):
				$this->load->view('templates/header', $data);
				$this->load->view('comment/append', $data);
				$this->load->view('templates/footer', $data);
			else:
				$params['comment_id'] = $this->input->post('comment_id');
				$params['append'] = $this->input->post('append');

				$url = api_url('comment/append');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] == 200):
					echo '追加评论成功！';
				else:
					echo '追加评论失败，请重试！';
					$this->load->view('templates/header', $data);
					$this->load->view('comment/append', $data);
					$this->load->view('templates/footer', $data);
				endif;
			endif;
		}
		
	}