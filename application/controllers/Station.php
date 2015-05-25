<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	* Station Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Station extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		/**
		* Generate refuel station list page or detail page.
		*
		* @since always
		* @param int $station_id
		* @return void
		*/
		public function index($station_id = NULL)
		{
			if ($station_id === NULL):
				$params['region'] = $this->input->get('region'); // 地区限制
				$params['brand_id'] = $this->input->get('brand_id'); // 油站品牌ID
				$params['sort'] = $this->input->get('sort'); // 排序方式
			else:
				$params['station_id'] = $station_id;
			endif;
			
			$url = api_url('station');
		    $result = $this->curl->go($url, $params, 'array');
			
			// 若未传入station_id，生成油站列表页并设置相应class
			if ($station_id === NULL):
				$data['title'] = '所有加油站';
				$data['class'] = 'station station-index';
				$this->load->view('templates/header', $data);
			    $data['stations'] = $result['content'];
				$this->load->view('station/index', $data);
			
			// 若传入station_id，生成油站详情页并设置相应class
			else:
				$data['station'] = $result['content'];
				$data['title'] = $result['content']['name'];
				$data['class'] = 'station station-detail';
				$this->load->view('templates/header', $data);
				// 获取对该加油站的评论
				$url = api_url('comment/station');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] == 200):
					$data['comments'] = $result['content'];
				else:
					$data['comments'] = NULL;
				endif;
				$this->load->view('station/detail', $data);
			endif;
			$this->load->view('templates/footer', $data);
		}
	}