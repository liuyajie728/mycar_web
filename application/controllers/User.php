<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class User extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['title'] = '用户首页';
			$this->load->view('templates/header', $data);
			$this->load->view('blank');
			$this->load->view('templates/footer');
			
			$this->output->enable_profiler(TRUE);
		}
		
		// 用户登录
		public function login()
		{
			if($this->input->is_ajax_request()):
				$type = 1; // 注册/登陆短信类型默认为1
				$mobile = trim($this->input->get('mobile'));
				$params = array(
					'mobile' => $mobile,
					'type' => 1
				);
				$url = 'http://www.key2all.com/mycar_api/sms/send';

			    $curl = curl_init();
			    // 设置你要访问的URL
			    curl_setopt($curl, CURLOPT_URL, $url);
				// 设置cURL参数，内容为要请求的方式及内容
				curl_setopt($curl, CURLOPT_POST, count($params));
				curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
			    // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
			    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
			    // 运行cURL，请求API
			    $data = curl_exec($curl);
			    // 关闭URL请求
			    curl_close($curl);

				// 返回数据
				echo $data;

			else:
				/*
				$this->load->library('session');
			
				//若已登录，则直接转到首页
				if ($this->session->userdata('logged_in') === TRUE):
					redirect(base_url());
				endif;

				//向闪出session记录来源网址以备登录成功时跳转
				if ($this->input->server('HTTP_REFERER')):
					$this->session->set_flashdata('referer' , $this->input->server('HTTP_REFERER'));
				elseif ($this->session->flashdata('referer')):
					$this->session->keep_flashdata('referer');
				endif;
				*/
				$data['title'] = '我的车';
				$data['class'] = 'login';

				$this->form_validation->set_rules('mobile', '手机号', 'trim|required|is_natural|exact_length[11]');

				if($this->form_validation->run() === FALSE):
					$this->load->view('templates/header', $data);
					$this->load->view('user/login', $data);
					$this->load->view('templates/footer');
		
				else:
					//成功登录
					if($this->manager_model->login()):
						//获取会员信息
						$data['user'] = $this->user_model->login();

						//将员工信息写入session、cookie并转到首页
						$manager_data = array(
							'user_id' => $data['user']['stuff_id'],
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

						$this->session->set_userdata( $manager_data );
						//将员工ID及手机号写入cookie并保存1年
						$this->input->set_cookie('manager_mobile', $data['user']['mobile'], 60*60*24*365);
						$this->input->set_cookie('manager_id', $data['user']['stuff_id'], 60*60*24*365);
						if($this->session->flashdata('referer') && $this->session->flashdata('referer') != base_url()):
							redirect($this->session->flashdata('referer'));
						else:
							redirect(base_url());
						endif;
		
					//若员工不存在
					elseif(!$this->stuff_model->stuff_check()):
						$data['error'] = '<p>这个手机号尚未被注册，请确认。</p>';
						$this->load->view('templates/header', $data);
						$this->load->view('user/login', $data);
						$this->load->view('templates/footer');
			
					//若密码错误
					else:
						$data['error'] = '<p>密码不正确，请重试。</p>';
						$this->load->view('templates/header', $data);
						$this->load->view('user/login', $data);
						$this->load->view('templates/footer');
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