<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	* Curl类
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Curl
	{		
		public function go($url, $params, $return = 'object')
		{
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

			//转换返回的json数据为相应格式并返回
			if ($return == 'object'):
				$result = json_decode($result);
			elseif ($return == 'array'):
				$result = json_decode($result, TRUE);
			endif;

			return $result;
		}
	}
	
/* End of file Curl.php */
/* Location: ./application/libraries/Curl.php */