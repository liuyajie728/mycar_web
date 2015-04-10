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
			$this->load->view('welcome_message');
			$this->load->view('templates/footer');
			
			$this->output->enable_profiler(TRUE);
		}

		// 用户登录
		public function login()
		{
			//若已登录，则直接转到首页
			if($this->session->userdata('logged_in') === TRUE):
				redirect(base_url());
			endif;
			
			//向闪出session记录来源网址以备登录成功时跳转
			if($this->input->server('HTTP_REFERER')):
				$this->session->set_flashdata('referer' , $this->input->server('HTTP_REFERER'));
			elseif($this->session->flashdata('referer')):
				$this->session->keep_flashdata('referer');
			endif;

			$data['class'] = 'manager';
			$data['title'] = '登录';
	
			$this->form_validation->set_rules('mobile', '手机号', 'trim|required|is_natural|exact_length[11]');
			$this->form_validation->set_rules('password', '密码', 'trim|required|is_natural|exact_length[6]');
	
			if($this->form_validation->run() === FALSE):
				$this->load->view('templates/header', $data);
				$this->load->view('user/login', $data);
				$this->load->view('templates/footer');
		
			else:
				//成功登录
				if($this->manager_model->login()):
					//获取员工信息
					$data['manager'] = $this->manager_model->login();
					
					//将员工信息写入session、cookie并转到首页
					$manager_data = array(
						'manager_id' => $data['manager']['stuff_id'],
						'lastname'	=> $data['manager']['lastname'],
						'firstname'	=> $data['manager']['firstname'],
						'gender'	=> $data['manager']['gender'],
						'dob'	=> $data['manager']['dob'],
						'mobile'	=> $data['manager']['mobile'],
						'level'	=> $data['manager']['level'],
						'biz_id' => $data['manager']['biz_id'],
						'logged_in' => TRUE
					);
					if(!empty($data['manager']['brand_id'])):
						$manager_data['brand_id'] = $data['manager']['brand_id'];
					endif;
					if(!empty($data['manager']['branch_id'])):
						$manager_data['branch_id'] = $data['manager']['branch_id'];
					endif;
					
					$this->session->set_userdata( $manager_data );
					//将员工ID及手机号写入cookie并保存1年
					$this->input->set_cookie('manager_mobile', $data['manager']['mobile'], 60*60*24*365);
					$this->input->set_cookie('manager_id', $data['manager']['stuff_id'], 60*60*24*365);
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
		}

		// 用户退出
		public function logout()
		{
			$this->session->sess_destroy();
			//转到首页
			redirect(base_url());
		}
	}
