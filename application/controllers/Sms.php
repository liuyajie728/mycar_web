<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Sms extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['title'] = '短信首页';
			$this->load->view('templates/header', $data);
			$this->load->view('blank');
			$this->load->view('templates/footer');
			
			$this->output->enable_profiler(TRUE);
		}

		/**
		* Send sms through API
		*
		* @since always
		* @param int $type Sms type, login validation code by default.
		* @return json Sms sending results.
		*/
		public function send()
		{
			if($this->input->is_ajax_request()):
				$params['mobile'] = $this->input->get('mobile');
				$params['type'] = $this->input->get('type');
				$url = 'http://www.key2all.cn/sms/send';

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
			    $result = curl_exec($curl);
			    // 关闭URL请求
			    curl_close($curl);

				// 返回数据
				echo $result;
			endif;
		}
	}