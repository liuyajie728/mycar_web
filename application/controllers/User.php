<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class User extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		
		// User homepage
		public function index()
		{
			//若未登录，转到登录页
			if($this->session->userdata('logged_in') != TRUE):
				redirect(base_url('login'));
			endif;

			$data['title'] = '我';
			$data['class'] = 'user user-index';

			$data['me'] = $this->get_me($this->input->cookie('user_id'));
			
			$this->load->view('templates/header', $data);
			$this->load->view('user/index', $data);
			$this->load->view('templates/footer', $data);
		}
		
		// Get user's data
		private function get_me($user_id)
		{
			$params['user_id'] = $user_id;
			$url = 'http://www.key2all.cn/user/';
			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, count($params));
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
			$result = curl_exec($curl);
			curl_close($curl);
			return $result;
		}

		// 用户登录
		public function login()
		{
			//若已登录，则直接转到首页
			if($this->session->userdata('logged_in') === TRUE):
				redirect(base_url());
			endif;
			
			if($this->input->is_ajax_request()):
				$params['captcha'] = $this->input->get('captcha');
				$params['mobile'] = $this->input->get('mobile');
				$params['sms_id'] = $this->input->get('sms_id');
				
				$url = api_url('user/login');
			    $curl = curl_init();
			    curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_POST, count($params));
				curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
			    // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
			    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
			    // 运行cURL，请求API
			    $result = curl_exec($curl);
			    // 关闭URL请求
			    curl_close($curl);

				// 返回数据
				echo $result;

			else:
				$data['title'] = '我的车';
				$data['class'] = 'user user-login';

				$this->form_validation->set_rules('mobile', '手机号', 'trim|required|is_natural|exact_length[11]');

				if($this->form_validation->run() === FALSE):
					$this->load->view('templates/header', $data);
					$this->load->view('user/login', $data);
					$this->load->view('templates/footer', $data);
		
				else:
					//成功登录
					if($this->manager_model->login()):
						//获取会员信息
						$data['user'] = $this->user_model->login();

						//将员工信息写入session、cookie并转到首页
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
						$this->input->set_cookie('user_id', $data['user']['stuff_id'], 60*60*24*365);
						if($this->session->flashdata('referer') && $this->session->flashdata('referer') != base_url()):
							redirect($this->session->flashdata('referer'));
						else:
							redirect(base_url());
						endif;
					endif;
				endif;
			endif;
		}

		// 用户退出
		public function logout()
		{
			$this->session->sess_destroy();
			//转到首页
			redirect(base_url());
		}
	}