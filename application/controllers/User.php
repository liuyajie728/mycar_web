<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	* User Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class User extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		/**
		* Generate user home page.
		*
		* @since always
		* @param void
		* @return void
		*/
		public function index()
		{
			// Redirect to login page if not logged in.
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;

			$data['title'] = '我';
			$data['class'] = 'user user-index';

			$data['me'] = $this->get_me();			
			$this->load->view('templates/header', $data);
			$this->load->view('user/index', $data);
			$this->load->view('templates/footer', $data);
		}

		/**
		* Get current user data.
		*
		* @since always
		* @param void
		* @return void
		*/
		private function get_me()
		{
			$params['user_id'] = $this->session->userdata('user_id');

			$url = api_url('user');
			$result = $this->curl->go($url, $params, 'array');
			return $result['content'];
		}

		/**
		* User login with AJAX
		*
		* @since always
		* @param int(4) $_GET['captcha']
		* @param int(11) $_GET['mobile']
		* @param int $_GET['sms_id']
		* @return json Login result.
		*/
		public function login()
		{
			// Redirect to home page if already logged in.
			if($this->session->userdata('logged_in') === TRUE):
				redirect(base_url());
			endif;

			if($this->input->is_ajax_request()):
				$params['captcha'] = $this->input->get('captcha');
				$params['mobile'] = $this->input->get('mobile');
				$params['sms_id'] = $this->input->get('sms_id');

				$url = api_url('user/login');
				$result = $this->curl->go($url, $params, 'array');

				// Return login result according to api return json.
				if ($result['status'] != 200):
					$output['status'] = 400;
					$output['content'] = 'Login failed.';
					header("Content-type:application/json;charset=utf-8");
					$output_json = json_encode($output);
					echo $output_json;
					
				else:
					$data['user'] = $result['content'];
					// 如果成功登陆则将用户信息写入session
					$user_data = array(
						'user_id' => $data['user']['user_id'],
						'nickname'	=> $data['user']['nickname'],
						'lastname'	=> $data['user']['lastname'],
						'firstname'	=> $data['user']['firstname'],
						'gender'	=> $data['user']['gender'],
						'dob'	=> $data['user']['dob'],
						'logo_url' => $data['user']['logo_url'],
						'mobile'	=> $data['user']['mobile'],
						'email'	=> $data['user']['email'],
						'time_join'	=> $data['user']['time_join'],
						'time_last_activity'	=> $data['user']['time_last_activity'],
						'logged_in' => TRUE
					);
					$this->session->set_userdata($user_data);
					//将会员ID及手机号写入cookie并保存1年
					$this->input->set_cookie('mobile', $data['user']['mobile'], 60*60*24*365);
					$this->input->set_cookie('user_id', $data['user']['user_id'], 60*60*24*365);
					
					// 通知页面跳转到登录前页面，若无则跳转到首页
					if($this->session->flashdata('referer') && $this->session->flashdata('referer') != base_url()):
						$output['content']['target_url'] = $this->session->flashdata('referer');
					else:
						$output['content']['target_url'] = base_url();
					endif;
					$output['status'] = 200;
					header("Content-type:application/json;charset=utf-8");
					$output_json = json_encode($output);
					echo $output_json;
				endif;

			else:
				//向闪出session记录来源网址以备登录成功时跳转
				if ($this->input->server('HTTP_REFERER')):
					$this->session->set_flashdata('referer', $this->input->server('HTTP_REFERER'));
				elseif ($this->session->flashdata('referer')):
					$this->session->keep_flashdata('referer');
				endif;

				$data['title'] = '哎油';
				$data['class'] = 'user user-login';
				
				$params['article_id'] = 1;
				$url = api_url('article');
			    $result = $this->curl->go($url, $params, 'array');
				$data['article'] = $result['content'];

				if($this->form_validation->run() === FALSE):
					$this->load->view('templates/header', $data);
					$this->load->view('user/login', $data);
					$this->load->view('templates/footer', $data);
				endif;
			endif;
		}

		/**
		* User logout
		*
		* @since always
		* @param void
		* @return void
		*/
		public function logout()
		{
			$this->session->sess_destroy();
			//转到首页
			redirect(base_url());
		}
	}