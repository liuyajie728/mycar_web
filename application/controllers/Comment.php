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
		
		public function comment($order_id)
		{
			$params['user_id'] = $this->session->user_id;
			$data['title'] = '订单评价';
			$data['class'] = 'comment comment-create';

			$this->load->view('templates/header', $data);
			$this->load->view('comment/create', $data);
			$this->load->view('templates/footer', $data);
		}
		
		public function append($comment_id) // Causion here!!! Parameter must be $comment_id, NOT $order_id!!!
		{
			$params['user_id'] = $this->session->user_id;
			$data['title'] = '追加评价';
			$data['class'] = 'comment comment-append';

			$this->load->view('templates/header', $data);
			$this->load->view('comment/append', $data);
			$this->load->view('templates/footer', $data);
		}
		
	}