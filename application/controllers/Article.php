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
			$data['title'] = '文章详情';
			$data['class'] = 'article article-detail';

			if ($article_id != NULL):
				$params['article_id'] = $article_id;
			endif;

			$url = api_url('article');
		    $result = $this->curl->go($url, $params, 'array');
			$data['article'] = $result['content'];

			$this->load->view('templates/header', $data);
			$this->load->view('article/detail', $data);
			$this->load->view('templates/footer', $data);
		}
	}