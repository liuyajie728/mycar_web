<?php
	if (!defined('BASEPATH')) exit('此文件不可被直接访问');

	/**
	* Wechat Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Wechat extends CI_Controller
	{
		protected $appid = APP_ID; // appid，微信公众平台提供，静态
		protected $appsecret = APP_SECRET; // appsecret，微信公众平台提供，静态，可通过微信公众平台后台重置更换
		protected $token = WECHAT_TOKEN; // token，需与微信公众平台后台相关设置项一致

		protected $access_token; // access_token，需要时通过相应API从微信公众平台获取

		public $message_input; // 接收到的消息
		public $message_output; // 发送出去的消息
		public $input_type = 'text'; //接收到的消息类型，默认为文本消息
		public $output_type = 'news'; //发送出的消息类型，默认为图文消息
		public $user_name; // 用户ID
		public $account_name; // 微信公众号ID

		public $api_urls = array( // 微信公众平台API网址
			'access_token_get' => 'https://api.weixin.qq.com/cgi_bin/token?grant_type=client_credential&appid=%s&secret=%s', // 获取access_token
			'get_qrcode' => 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=%s', // 获取临时/永久二维码
			'menu_create' => 'https://api.weixin.qq.com/cgi_bin/menu/create?access_token=%s', // 创建自定义菜单
			'menu_get' => 'https://api.weixin.qq.com/cgi_bin/menu/get?access_token=%s', // 获取自定义菜单
			'menu_delete' => 'https://api.weixin.qq.com/cgi_bin/menu/delete?access_token=%s' // 删除自定义菜单
		);

		public $output_templates = array( // 发送消息模板
			'header' => '<?xml version="1.0" encoding="UTF-8"?>
							<xml>
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%s</CreateTime>
								<MsgType><![CDATA[%s]]></MsgType>', // 通用模板头部
			'footer' => '<FuncFlag>0</FuncFlag></xml>', // 通用模板尾部
			'text' => '<Content><![CDATA[%s]]></Content>', // 文本消息模板
			'image' => '<Image><MediaId><![CDATA[%s]]></MediaId></Image>', // 图片消息模板
			'voice' => '<Voice><MediaId><![CDATA[%s]]></MediaId></Voice>', // 语音消息模板（必须上传）
			'music' => '<Music>
							<Title><![CDATA[%s]]></Title>
							<Description><![CDATA[%s]]></Description>
							<MusicUrl><![CDATA[%s]]></MusicUrl>
							<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
							<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
						</Music>', // 音乐模板（可外链）
			'video' => '<Video>
							<MediaId><![CDATA[%s]]></MediaId>
							<Title><![CDATA[%s]]></Title>
							<Description><![CDATA[%s]]></Description>
						</Video>', // 视频消息模板
			'news' => array( // 图文消息模板
				'frame' => '<ArticleCount>%s</ArticleCount><Articles>%s</Articles>', // 图文消息开头
				'item' => '<item>
							<Title><![CDATA[%s]]></Title>
							<Description><![CDATA[%s]]></Description>
							<PicUrl><![CDATA[%s]]></PicUrl>
							<Url><![CDATA[%s]]></Url>
						</item>' // 图文消息项
			)
		);

		public function __construct()
		{
			parent::__construct();

			// 验证信息来自微信
			if (!$this->checkSignature()):
				echo '仅用于微信公众平台开发!';
				exit;
			endif;

			// 验证开发者身份
			if ($this->input->get('echostr')):
				$this->valid();
				exit;
			endif;
			
			// 接收用户发来的各类型信息
			$this->message_input = file_get_contents('php://input');

			//验证收到的消息不为空
			if (!empty($message_input)):
				$this->message_input = $message_input;
			else:
				echo '接收到的消息为空!';
			//	exit;
			endif;
		}
		
		//检查签名
		private function checkSignature()
		{
			$signature = $this->input->get('signature');
			$timestamp = $this->input->get('timestamp');
			$nonce = $this->input->get('nonce');
			$token = $this->token;

			$tmpArr = array($token, $timestamp, $nonce);

			sort($tmpArr, SORT_STRING);
			$tmpStr = implode($tmpArr);
			$tmpStr = sha1($tmpStr);

			if ($tmpStr == $signature):
				return TRUE;
			else:
				return FALSE;
			endif;
		}

		//验证开发者身份
		private function valid()
		{
			$echoStr = $this->input->get('echostr');
			//验证签名，可选项
			if ($this->checkSignature()):
				echo $echoStr;
				exit;
			endif;
		}
		
		/**
		* GET access_token from wechat server
		*
		* @since always
		* @param void
		* @return string $access_token
		*/
		private function get_access_token()
		{
			$url = sprintf($this->api_urls['access_token_get'], APP_ID, APP_SECRET);
			$reslut = $this->curl->go($url, $params, 'array', 'get');
			return $access_token = $result['access_token'];
		}
		
		/**
		* Transfer google coordinates to baidu coordinates through baidu API
		*
		* @since always
		* @param decimal $weidu
		* @param decimal $$jingdu
		* @return string
		*/
		public function get_baidu_coor($weidu, $jingdu)
		{
			// 使用百度的API将微信获取到的谷歌坐标系坐标转换为百度坐标系坐标
			$coords = $weidu. ','. $jingdu;
			$url = 'http://api.map.baidu.com/geoconv/v1/?from=3&to=5&ak=xjkNHSD9fwhrL3v7P3hUBCwc&coords='. $coords;
			$result = $this->curl->go($url, NULL, 'array', 'get');
			return $result['result'][0];
		}

		// 处理消息消息
		public function index()
		{
			// 解析信息
			$input = simplexml_load_string($this->message_input, 'SimpleXMLElement', LIBXML_NOCDATA); // 解析收到的用户消息XML对象为PHP对象
			$this->user_name = $input->FromUserName; // 接收到的消息发送方ID
			$this->account_name = $input->ToUserName; // 接收到的消息接收方ID，即公众号ID
			$type = $input->MsgType; // 接收到的消息类型

			// 默认回复类型及回复语
			if ($type == 'text'):
				$this->message_input = trim($input->Content);

				// 默认回复
				$this->output_type = 'text';
				$content = '哎油目前没有为“'. $this->message_input. '”准备特别的服务，请使用下方菜单。么么哒。';
				$this->reply($content);
			endif;
			
			// 地理位置推送
			if ($type == 'location'):
				// 解析地理位置
				$weidu = $input->Location_X; // 微信获取到的谷歌坐标系纬度
				$jingdu = $input->Location_Y; // 微信获取到的谷歌坐标系经度
				$transformed_coords = $this->get_baidu_coor($jingdu, $weidu); // 通过百度API转换坐标系
				$jingdu_t = $transformed_coords['x']; // 百度坐标系经度
				$weidu_t = $transformed_coords['y']; // 百度坐标系纬度
				
				// 生成回复内容
				$title = '最近的加油站已经找到！';
				$description = '哎油已经为您挑选出了距离最近的加油/加气/充电站，请点击查看~';
				$pic_url = 'https://mmbiz.qlogo.cn/mmbiz/4goiaMRM40YZ9duftavdqENpEGO5GKpEusKia76I1p1vBRsH84a1evn7fr1BTQWebJngej92iaZ0UJ7GQxUMIicnoQ/0?wx_fmt=jpeg';
				$url = base_url('home/'. rawurlencode($weidu_t). '/'. rawurlencode($jingdu_t));

				// 将回复推入待发送内容
				$content[] = array(
					'title' => $title,
					'description' => $description,
					'pic_url' => $pic_url,
					'url' => $url
				);

				// 发送图文消息
				$this->output_type = 'news';
				$this->reply($content);
				
			endif;

			// 用户订阅或退订
			if ($type == 'event'):
				$event = $input->Event;
				// 用户订阅或扫描
				if ($event == 'subscribe' || $event == 'SCAN'):
					// 如果是扫描带参数二维码码事件，推送到思特朗RESTful API进行记录
					if (isset($input->EventKey)):
						$params['user_ip'] = $this->input->ip_address();
						$params['user_agent'] = $this->input->user_agent();
						$params['url'] = $input->EventKey;
						$url = 'http://www.sitelang.cn/r/api';
						$result = $this->curl->go($url, $params);
					endif;

					// 生成回复内容
					$title = '你好，欢迎来到哎油iRefuel。';
					$description = '点击此处即刻申请哎油会员，与百万车友同享前所未有的优质、安全、极速加油体验。';
					$pic_url = 'https://mmbiz.qlogo.cn/mmbiz/4goiaMRM40YYHM3IO7jjQbeUibW2WKoDEibvOn5HMY8SeLm2G3CDGME2a3PMibyZRiaK3lNVp3Rmtff2zcnGebUoicicg/0?wx_fmt=jpeg';
					$url = base_url('login');

					// 将回复推入待发送内容
					$content[] = array(
						'title' => $title,
						'description' => $description,
						'pic_url' => $pic_url,
						'url' => $url
					);

					// 发送图文消息
					$this->output_type = 'news';
					$this->reply($content);

				// 用户退订，无法向用户发送任何信息，只可做内部操作
				elseif ($event == 'unsubscribe'):
					exit;
				endif;
			endif;
		}
		
		//回复消息到用户
		public function reply($content)
		{
			// 生成准备回复的消息头部及尾部
			$header = sprintf($this->output_templates['header'], $this->user_name, $this->account_name, time(), $this->output_type);
			$footer = $this->output_templates['footer'];

			// 组装内容模板及内容以生成消息体
			switch($this->output_type)
			{
				case 'news': // 发送图文消息
					$news_items = array();
					// 拼接图文消息模板
					foreach($content as $news_item)
					{
						$single_item = sprintf($this->output_templates['news']['item'], $news_item['title'], $news_item['description'], $news_item['pic_url'], $news_item['url']);
						array_push($news_items, $single_item);
					}
					$news_content = '';
					foreach($news_items as $news_item)
					{
						$news_content .= $news_item;
					}
					$content = sprintf($this->output_templates['news']['frame'], count($news_items), $news_content);
					break;
				case 'music': // 发送音乐消息
					$content = sprintf($this->output_templates['music'], $content['title'], $content['description'], $content['music_url'], $content['hq_music_url'], $content['thumb_media_id']);
					break;

				case 'video': // 发送视频消息
					$content = sprintf($this->output_templates['video'], $content['media_id'], $content['title'], $content['description']);
					break;

				default: // 发送文本、图片、语音消息（即当$this->output_type为text/image/voice时）
					$content = sprintf($this->output_templates[$this->output_type], $content);
			}

			// 组装消息头尾部及消息体，并输出；由于微信API限制，只可用echo方式，不可用return
			$this->message_output = $header. $content. $footer;
			echo $this->message_output;
		}
	}

/* End of file Wechat.php */
/* Location: ./application/controllers/Wechat.php */