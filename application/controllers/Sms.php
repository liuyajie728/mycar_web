<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Sms extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		/**
		* Send sms through API
		*
		* @since always
		* @param int $_POST['mobile'] SMS receiver mobile number.
		* @param int $_POST['type'] SMS type, login validation code by default.
		* @return json Sms sending results.
		*/
		public function send()
		{
			if($this->input->is_ajax_request()):
				$params['mobile'] = $this->input->get('mobile');
				$params['type'] = $this->input->get('type');
				
				$url = api_url('sms/send');
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
			endif;
		}
	}