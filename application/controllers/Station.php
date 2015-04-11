<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Station extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function index($station_id = NULL)
		{
			$data['title'] = '加油站';
			$data['class'] = 'station';
			
			if ($station_id === NULL):
				$params['station_id'] = $station_id;
			else:
				$params['region'] = $this->input->get('region'); // 地区限制
				$params['brand_id'] = $this->input->get('brand_id'); // 油站品牌ID
				$params['sort'] = $this->input->get('sort'); // 排序方式
			endif;
			$url = 'http://www.key2all.com/mycar_api/station';
			
		    $curl = curl_init();
		    // 设置你要访问的URL
		    curl_setopt($curl, CURLOPT_URL, $url);
			// 设置cURL参数，内容为要请求的方式及内容
			curl_setopt($curl, CURLOPT_POST, count($params));
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		    // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');

			$this->load->view('templates/header', $data);
			// 运行cURL，请求API
			if ($station_id === NULL):
			    $data['stations'] = curl_exec($curl);
				$this->load->view('station/index', $data);
			else:
			    $data['station'] = curl_exec($curl);
				$this->load->view('station/detail', $data);
			endif;
			$this->load->view('templates/footer');
			
		    // 关闭URL请求
		    curl_close($curl);
			
			$this->output->enable_profiler(TRUE);
		}

		/**
		* Send sms through API
		*
		* @since always
		* @param int $type Sms type, login validation code by default.
		* @return json Sms sending results.
		*/
		public function send($type = 1)
		{
			if($this->input->is_ajax_request()):
				$params['mobile'] = $this->input->get('mobile');
				$params['type'] = $this->input->get('type');
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
			    $result = curl_exec($curl);
			    // 关闭URL请求
			    curl_close($curl);

				// 返回数据
				echo $result;
			endif;
		}
	}