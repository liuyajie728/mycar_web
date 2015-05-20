<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	* Sms Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
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
				$result = $this->curl->go($url, $params);
				
				// Convert to json format for ajax return.
				header("Content-type:application/json;charset=utf-8");
				$output_json = json_encode($result);
				echo $output_json;
			endif;
		}
	}