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
		
		public function comment()
		{
			$params['user_id'] = $this->session->user_id;
			$data['title'] = '订单评价';
			$data['class'] = 'Comment Comment-comment';

			$this->load->view('templates/header', $data);
			$this->load->view('Comment/comment', $data);
			$this->load->view('templates/footer', $data);
		}
		
		public function append()
		{
			$params['user_id'] = $this->session->user_id;
			$data['title'] = '订单评价';
			$data['class'] = 'Comment Comment-comment Comment-comment-append';

			$this->load->view('templates/header', $data);
			$this->load->view('Comment/comment_append', $data);
			$this->load->view('templates/footer', $data);
		}
		
	}