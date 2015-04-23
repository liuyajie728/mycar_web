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

			$data['me'] = $this->get_me($this->session->userdata('user_id'));			
			$this->load->view('templates/header', $data);
			$this->load->view('user/index', $data);
			$this->load->view('templates/footer', $data);
		}

		// Get user's data
		private function get_me($user_id)
		{
			$params['user_id'] = $user_id;
			$url = api_url('user');
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, count($params));
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
			$result = json_decode(curl_exec($curl), TRUE);
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
				// 将返回的json对象转换成关联数组
				$result = json_decode(curl_exec($curl), TRUE);
			    // 关闭URL请求
			    curl_close($curl);

				// 返回数据
				//echo $result;
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

				if($this->form_validation->run() === FALSE):
					$this->load->view('templates/header', $data);
					$this->load->view('user/login', $data);
					$this->load->view('templates/footer', $data);
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