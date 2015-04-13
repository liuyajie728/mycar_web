<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Home extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['title'] = '首页';
			$data['class'] = 'home';

			$this->load->view('templates/header', $data);
			$this->load->view('home', $data);
			$this->load->view('templates/footer');
		}
	}