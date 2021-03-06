<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	define('BASE_URL', 'http://web.irefuel.cn/');
	
	define('DEFAULT_IMG_STATION', BASE_URL. 'images/default_station.jpg');
	define('DEFAULT_IMG_USER', BASE_URL. 'images/default_user.png');
	
	// Wechat Setups
	define('APP_ID', 'wx920a184018cc7654');
	define('APP_SECRET', '1ce56c3e71ff076f6f78ce5e845449e6');
	define('WECHAT_TOKEN', 't0JxKenbPhFs7uMgRZNWXwGpEoqvYIf4');

	// Wepay Setups
	define('WEPAY_URL', 'http://www.jiayoucar.com/web/wepay/demo/');
	function wepay_url($api_name)
	{
		$wepay_url = WEPAY_URL. $api_name;
		return $wepay_url;
	}

	// RESTful API
	define('API_TOKEN', '7C4l7JLaM3Fq5biQurtmk6nFS');
	define('API_URL', 'http://api.irefuel.cn/');
	function api_url($api_name)
	{
		$api_url = API_URL. $api_name;
		return $api_url;
	}

	date_default_timezone_set('Asia/Shanghai');

	// 将根据油站评分显示星级标志
	function rate2star($rate_value)
	{
		$star = '<i class="fa fa-star"></i>'; // 一颗亮星
		$half_star = '<i class="fa fa-star-half"></i>'; // 半颗亮星
		$dim_star = '<i class="fa fa-star dim-star"></i>';  // 一颗亮星，需自定义.dim-star样式为background-color:#aaa等
		switch($rate_value)
		{
			case $rate_value >= 95:
				$star_html = $star.$star.$star.$star.$star;
				break;
			case $rate_value >= 90:
				$star_html = $star.$star.$star.$star.$half_star;
				break;
			case $rate_value >= 80:
				$star_html = $star.$star.$star.$star.$dim_star;
				break;
			case $rate_value >= 70:
				$star_html = $star.$star.$star.$half_star.$dim_star;
				break;
			case $rate_value >= 60:
				$star_html = $star.$star.$star.$dim_star.$dim_star;
				break;
			case $rate_value >= 50:
				$star_html = $star.$star.$half_star.$dim_star.$dim_star;
				break;
			case $rate_value >= 40:
				$star_html = $star.$star.$dim_star.$dim_star.$dim_star;
				break;
			case $rate_value >= 30:
				$star_html = $star.$half_star.$dim_star.$dim_star.$dim_star;
				break;
			case $rate_value >= 20:
				$star_html = $star.$dim_star.$dim_star.$dim_star.$dim_star;
				break;
			case $rate_value >= 10:
				$star_html = $half_star.$dim_star.$dim_star.$dim_star.$dim_star;
				break;
			default:
				$star_html = $dim_star.$dim_star.$dim_star.$dim_star.$dim_star;
		}
		return $star_html;
	}

	// 显示订单状态
	function show_order_status($status_code)
	{
		switch($status_code):
			case '0':
				$status = '待支付';
				break;
			case '1':
				$status = '已过期';
				break;
			case '2':
				$status = '已取消';
				break;
			case '3':
				$status = '已支付';
				break;
			case '4':
				$status = '已评论';
				break;
			case '5':
				$status = '已追加评论';
				break;
			default:
				break;
		endswitch;
		return $status;
	}
	
	// 显示支付方式
	function show_payment_type($payment_type)
	{
		switch($payment_type):
			case '0':
				$type = '余额支付';
				break;
			case '1':
				$type = '微信支付';
				break;
			case '2':
				$type = '余额 + 微信支付';
				break;
			case '3':
				$type = '支付宝';
				break;
			case '4':
				$type = '余额 + 支付宝';
		endswitch;
		return $type;
	}

	/**
	* Native CodeIgniter configs from here.
	* @since always
	*/
	$config['base_url'] = BASE_URL;
	$config['index_page'] = 'index.php';
	$config['uri_protocol']	= 'REQUEST_URI';
	$config['url_suffix'] = '';
	$config['language']	= 'chinese';
	$config['charset'] = 'UTF-8';

	/*
	|--------------------------------------------------------------------------
	| Enable/Disable System Hooks
	|--------------------------------------------------------------------------
	|
	| If you would like to use the 'hooks' feature you must enable it by
	| setting this variable to TRUE (boolean).  See the user guide for details.
	|
	*/
	$config['enable_hooks'] = FALSE;

	/*
	|--------------------------------------------------------------------------
	| Class Extension Prefix
	|--------------------------------------------------------------------------
	|
	| This item allows you to set the filename/classname prefix when extending
	| native libraries.  For more information please see the user guide:
	|
	| http://codeigniter.com/user_guide/general/core_classes.html
	| http://codeigniter.com/user_guide/general/creating_libraries.html
	|
	*/
	$config['subclass_prefix'] = 'MY_';

	/*
	|--------------------------------------------------------------------------
	| Composer auto-loading
	|--------------------------------------------------------------------------
	|
	| Enabling this setting will tell CodeIgniter to look for a Composer
	| package auto-loader script in application/vendor/autoload.php.
	|
	|	$config['composer_autoload'] = TRUE;
	|
	| Or if you have your vendor/ directory located somewhere else, you
	| can opt to set a specific path as well:
	|
	|	$config['composer_autoload'] = '/path/to/vendor/autoload.php';
	|
	| For more information about Composer, please visit http://getcomposer.org/
	|
	| Note: This will NOT disable or override the CodeIgniter-specific
	|	autoloading (application/config/autoload.php)
	*/
	$config['composer_autoload'] = FALSE;

	/*
	|--------------------------------------------------------------------------
	| Allowed URL Characters
	|--------------------------------------------------------------------------
	|
	| This lets you specify which characters are permitted within your URLs.
	| When someone tries to submit a URL with disallowed characters they will
	| get a warning message.
	|
	| As a security measure you are STRONGLY encouraged to restrict URLs to
	| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
	|
	| Leave blank to allow all characters -- but only if you are insane.
	|
	| The configured value is actually a regular expression character group
	| and it will be executed as: ! preg_match('/^[<permitted_uri_chars>]+$/i
	|
	| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
	|
	*/
	$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

	/*
	|--------------------------------------------------------------------------
	| Enable Query Strings
	|--------------------------------------------------------------------------
	|
	| By default CodeIgniter uses search-engine friendly segment based URLs:
	| example.com/who/what/where/
	|
	| By default CodeIgniter enables access to the $_GET array.  If for some
	| reason you would like to disable it, set 'allow_get_array' to FALSE.
	|
	| You can optionally enable standard query string based URLs:
	| example.com?who=me&what=something&where=here
	|
	| Options are: TRUE or FALSE (boolean)
	|
	| The other items let you set the query string 'words' that will
	| invoke your controllers and its functions:
	| example.com/index.php?c=controller&m=function
	|
	| Please note that some of the helpers won't work as expected when
	| this feature is enabled, since CodeIgniter is designed primarily to
	| use segment based URLs.
	|
	*/
	$config['allow_get_array'] = TRUE;
	$config['enable_query_strings'] = FALSE;
	$config['controller_trigger'] = 'c';
	$config['function_trigger'] = 'm';
	$config['directory_trigger'] = 'd';

	/*
	|--------------------------------------------------------------------------
	| Error Logging Threshold
	|--------------------------------------------------------------------------
	|
	| If you have enabled error logging, you can set an error threshold to
	| determine what gets logged. Threshold options are:
	| You can enable error logging by setting a threshold over zero. The
	| threshold determines what gets logged. Threshold options are:
	|
	|	0 = Disables logging, Error logging TURNED OFF
	|	1 = Error Messages (including PHP errors)
	|	2 = Debug Messages
	|	3 = Informational Messages
	|	4 = All Messages
	|
	| You can also pass an array with threshold levels to show individual error types
	|
	| 	array(2) = Debug Messages, without Error Messages
	|
	| For a live site you'll usually only enable Errors (1) to be logged otherwise
	| your log files will fill up very fast.
	|
	*/
	$config['log_threshold'] = 0;

	/*
	|--------------------------------------------------------------------------
	| Error Logging Directory Path
	|--------------------------------------------------------------------------
	|
	| Leave this BLANK unless you would like to set something other than the default
	| application/logs/ directory. Use a full server path with trailing slash.
	|
	*/
	$config['log_path'] = '';

	/*
	|--------------------------------------------------------------------------
	| Log File Extension
	|--------------------------------------------------------------------------
	|
	| The default filename extension for log files. The default 'php' allows for
	| protecting the log files via basic scripting, when they are to be stored
	| under a publicly accessible directory.
	|
	| Note: Leaving it blank will default to 'php'.
	|
	*/
	$config['log_file_extension'] = '';

	/*
	|--------------------------------------------------------------------------
	| Log File Permissions
	|--------------------------------------------------------------------------
	|
	| The file system permissions to be applied on newly created log files.
	|
	| IMPORTANT: This MUST be an integer (no quotes) and you MUST use octal
	|            integer notation (i.e. 0700, 0644, etc.)
	*/
	$config['log_file_permissions'] = 0644;
	$config['log_date_format'] = 'Y-m-d H:i:s';

	/*
	|--------------------------------------------------------------------------
	| Error Views Directory Path
	|--------------------------------------------------------------------------
	|
	| Leave this BLANK unless you would like to set something other than the default
	| application/views/errors/ directory.  Use a full server path with trailing slash.
	|
	*/
	$config['error_views_path'] = '';

	/*
	|--------------------------------------------------------------------------
	| Cache Directory Path
	|--------------------------------------------------------------------------
	|
	| Leave this BLANK unless you would like to set something other than the default
	| application/cache/ directory.  Use a full server path with trailing slash.
	|
	*/
	$config['cache_path'] = '';

	/*
	|--------------------------------------------------------------------------
	| Cache Include Query String
	|--------------------------------------------------------------------------
	|
	| Set this to TRUE if you want to use different cache files depending on the
	| URL query string.  Please be aware this might result in numerous cache files.
	|
	*/
	$config['cache_query_string'] = FALSE;

	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| If you use the Encryption class, you must set an encryption key.
	| See the user guide for more info.
	|
	| http://codeigniter.com/user_guide/libraries/encryption.html
	|
	*/
	$config['encryption_key'] = 'irefuel_web';

	/*
	|--------------------------------------------------------------------------
	| Session Variables
	|--------------------------------------------------------------------------
	|
	| 'sess_driver'
	|
	|	The storage driver to use: files, database, redis, memcached
	|
	| 'sess_cookie_name'
	|
	|	The session cookie name, must contain only [0-9a-z_-] characters
	|
	| 'sess_expiration'
	|
	|	The number of SECONDS you want the session to last.
	|	Setting to 0 (zero) means expire when the browser is closed.
	|
	| 'sess_save_path'
	|
	|	The location to save sessions to, driver dependant.
	|
	|	For the 'files' driver, it's a path to a writable directory.
	|	WARNING: Only absolute paths are supported!
	|
	|	For the 'database' driver, it's a table name.
	|	Please read up the manual for the format with other session drivers.
	|
	|	IMPORTANT: You are REQUIRED to set a valid save path!
	|
	| 'sess_match_ip'
	|
	|	Whether to match the user's IP address when reading the session data.
	|
	| 'sess_time_to_update'
	|
	|	How many seconds between CI regenerating the session ID.
	|
	| 'sess_regenerate_destroy'
	|
	|	Whether to destroy session data associated with the old session ID
	|	when auto-regenerating the session ID. When set to FALSE, the data
	|	will be later deleted by the garbage collector.
	|
	| Other session cookie settings are shared with the rest of the application,
	| except for 'cookie_prefix' and 'cookie_httponly', which are ignored here.
	|
	*/
	$config['sess_driver'] = 'database';
	$config['sess_cookie_name'] = 'ci_session';
	$config['sess_expiration'] = 2592000; // 有效期30天 60*60*24*30
	$config['sess_save_path'] = 'ci_sessions';
	$config['sess_match_ip'] = FALSE;
	$config['sess_time_to_update'] = 300;
	$config['sess_regenerate_destroy'] = FALSE;

	$config['cookie_prefix']	= '';
	$config['cookie_domain']	= '.irefuel.cn';
	$config['cookie_path']		= '/';
	$config['cookie_secure']	= FALSE;
	$config['cookie_httponly'] 	= FALSE;

	/*
	|--------------------------------------------------------------------------
	| Standardize newlines
	|--------------------------------------------------------------------------
	|
	| Determines whether to standardize newline characters in input data,
	| meaning to replace \r\n, \r, \n occurences with the PHP_EOL value.
	|
	| This is particularly useful for portability between UNIX-based OSes,
	| (usually \n) and Windows (\r\n).
	|
	*/
	$config['standardize_newlines'] = FALSE;

	/*
	|--------------------------------------------------------------------------
	| Cross Site Request Forgery
	|--------------------------------------------------------------------------
	| Enables a CSRF cookie token to be set. When set to TRUE, token will be
	| checked on a submitted form. If you are accepting user data, it is strongly
	| recommended CSRF protection be enabled.
	|
	| 'csrf_token_name' = The token name
	| 'csrf_cookie_name' = The cookie name
	| 'csrf_expire' = The number in seconds the token should expire.
	| 'csrf_regenerate' = Regenerate token on every submission
	| 'csrf_exclude_uris' = Array of URIs which ignore CSRF checks
	*/
	$config['csrf_protection'] = FALSE;
	$config['csrf_token_name'] = 'csrf_test_name';
	$config['csrf_cookie_name'] = 'csrf_cookie_name';
	$config['csrf_expire'] = 7200;
	$config['csrf_regenerate'] = TRUE;
	$config['csrf_exclude_uris'] = array();

	/*
	|--------------------------------------------------------------------------
	| Output Compression
	|--------------------------------------------------------------------------
	|
	| Enables Gzip output compression for faster page loads.  When enabled,
	| the output class will test whether your server supports Gzip.
	| Even if it does, however, not all browsers support compression
	| so enable only if you are reasonably sure your visitors can handle it.
	|
	| Only used if zlib.output_compression is turned off in your php.ini.
	| Please do not use it together with httpd-level output compression.
	|
	| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
	| means you are prematurely outputting something to your browser. It could
	| even be a line of whitespace at the end of one of your scripts.  For
	| compression to work, nothing can be sent before the output buffer is called
	| by the output class.  Do not 'echo' any values with compression enabled.
	|
	*/
	$config['compress_output'] = FALSE;
	$config['time_reference'] = 'Asia/Shanghai';

	/*
	|--------------------------------------------------------------------------
	| Rewrite PHP Short Tags
	|--------------------------------------------------------------------------
	|
	| If your PHP installation does not have short tag support enabled CI
	| can rewrite the tags on-the-fly, enabling you to utilize that syntax
	| in your view files.  Options are TRUE or FALSE (boolean)
	|
	*/
	$config['rewrite_short_tags'] = FALSE;

	/*
	|--------------------------------------------------------------------------
	| Reverse Proxy IPs
	|--------------------------------------------------------------------------
	|
	| If your server is behind a reverse proxy, you must whitelist the proxy
	| IP addresses from which CodeIgniter should trust headers such as
	| HTTP_X_FORWARDED_FOR and HTTP_CLIENT_IP in order to properly identify
	| the visitor's IP address.
	|
	| You can use both an array or a comma-separated list of proxy addresses,
	| as well as specifying whole subnets. Here are a few examples:
	|
	| Comma-separated:	'10.0.1.200,192.168.5.0/24'
	| Array:		array('10.0.1.200', '192.168.5.0/24')
	*/
	$config['proxy_ips'] = '';

/* End of file config.php */
/* Location: ./application/config/config.php */