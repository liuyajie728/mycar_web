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
		public function index($weidu = NULL, $jingdu = NULL)
		{
			$data['title'] = '哎油';
			$data['class'] = 'home';
			
			($weidu != NULL)? $this->session->set_userdata('latitude', $weidu): $weidu = $this->session->latitude;
			($jingdu != NULL)? $this->session->set_userdata('longitude', $jingdu): $jingdu = $this->session->longitude;

			$data['station_brands'] = $this->get_station_brand();
			$data['stations'] = $this->get_station($weidu, $jingdu);

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
		public function get_station($weidu = NULL, $jingdu = NULL)
		{
			$params['latitude'] = $weidu;
			$params['longitude'] = $jingdu;
			$url = api_url('station');
			$result = $this->curl->go($url, $params, 'array');

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
			$result = $this->curl->go($url, $params, 'array');

			// 返回数据
			return $result['content'];
		}
	}