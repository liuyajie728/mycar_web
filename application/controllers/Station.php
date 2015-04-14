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
				$params['region'] = $this->input->get('region'); // 地区限制
				$params['brand_id'] = $this->input->get('brand_id'); // 油站品牌ID
				$params['sort'] = $this->input->get('sort'); // 排序方式
			else:
				$params['station_id'] = $station_id;
			endif;

			$url = 'http://www.key2all.cn/station';			
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
		    $result = json_decode(curl_exec($curl), TRUE); // 将json对象转换成关联数组
		    // 关闭URL请求
		    curl_close($curl);

			$this->load->view('templates/header', $data);
			// 运行cURL，请求API
			if ($station_id === NULL):
			    $data['stations'] = $result['content'];
				$this->load->view('station/index', $data);
			else:
			    $data['station'] = $result['content'];
				$this->load->view('station/detail', $data);
			endif;
			$this->load->view('templates/footer');
		}
	}