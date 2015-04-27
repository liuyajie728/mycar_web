<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	* Home Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Home extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		/**
		* Generate home page.
		*
		* @since always
		* @param void
		* @return void
		*/
		public function index()
		{
			$data['title'] = '哎油';
			$data['class'] = 'home';

			$data['stations'] = $this->get_station();
			$data['station_brands'] = $this->get_station_brand();
			
			$this->load->view('templates/header', $data);
			$this->load->view('home', $data);
			$this->load->view('templates/footer', $data);
		}

		/**
		* Get refuel station infos.
		*
		* @since always
		* @param int $station_id
		* @return array $result['content']
		*/
		public function get_station($station_id = NULL)
		{
			$params['station_id'] = $station_id;
			$url = api_url('station');

		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, count($params));
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		    // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
		    // 运行cURL，请求API
		    $result = json_decode(curl_exec($curl), TRUE); // 将json对象转换成关联数组
		    // 关闭URL请求
		    curl_close($curl);

			// 返回数据
			return $result['content'];
		}

		/**
		* Get refuel station brand infos.
		*
		* @since always
		* @param int $brand_id
		* @return array $result['content']
		*/
		public function get_station_brand($brand_id = NULL)
		{
			$params['brand_id'] = $brand_id;
			$url = api_url('station_brand');

		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, count($params));
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		    // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
		    // 运行cURL，请求API
		    $result = json_decode(curl_exec($curl), TRUE); // 将json对象转换成关联数组
		    // 关闭URL请求
		    curl_close($curl);

			// 返回数据
			return $result['content'];
		}
	}