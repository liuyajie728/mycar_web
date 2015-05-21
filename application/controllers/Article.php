<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	* Article Class
	*
	* @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	* @copyright SenseStrong <www.sensestrong.com>
	*/
	class Article extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		/**
		* Generate article detail page by article ID or nicename.
		*
		* @since always
		* @param int $article_id
		* @return void
		*/
		public function index($article_id = NULL)
		{
			$params['article_id'] = ($article_id != NULL)? $article_id: NULL;

			$url = api_url('article');
		    $result = $this->curl->go($url, $params, 'array');

			if ($article_id == NULL):
				$data['title'] = '文章列表';
				$data['class'] = 'article article-index';
				if ($result['status'] == '200'):
					$data['articles'] = $result['content'];
				else:
					$data['error'] = $result['content'];
				endif;
				$this->load->view('templates/header', $data);
				$this->load->view('article/index', $data);
			else:
				$data['title'] = '文章详情';
				$data['class'] = 'article article-detail';
				if ($result['status'] == '200'):
					$data['article'] = $result['content'];
				else:
					$data['error'] = $result['content'];
				endif;
				$this->load->view('templates/header', $data);
				$this->load->view('article/detail', $data);
			endif;
			
			$this->load->view('templates/footer', $data);
		}
	}