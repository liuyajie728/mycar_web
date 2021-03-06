<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/*
	| -------------------------------------------------------------------
	|  Auto-load Packages
	| -------------------------------------------------------------------
	| Prototype:
	|
	|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
	|
	*/
	$autoload['packages'] = array();

	/*
	| -------------------------------------------------------------------
	|  Auto-load Libraries
	| -------------------------------------------------------------------
	| These are the classes located in the system/libraries folder
	| or in your application/libraries folder.
	|
	| Prototype:
	|
	|	$autoload['libraries'] = array('database', 'email', 'session');
	|
	| You can also supply an alternative library name to be assigned
	| in the controller:
	|
	|	$autoload['libraries'] = array('user_agent' => 'ua');
	*/
	$autoload['libraries'] = array('database', 'form_validation', 'image_lib', 'session', 'curl');

	/*
	| -------------------------------------------------------------------
	|  Auto-load Drivers
	| -------------------------------------------------------------------
	| These classes are located in the system/libraries folder or in your
	| application/libraries folder within their own subdirectory. They
	| offer multiple interchangeable driver options.
	|
	| Prototype:
	|
	|	$autoload['drivers'] = array('cache');
	*/
	$autoload['drivers'] = array();

	$autoload['helper'] = array('cookie', 'date', 'form', 'security', 'string', 'url');

	/*
	| -------------------------------------------------------------------
	|  Auto-load Config files
	| -------------------------------------------------------------------
	| Prototype:
	|
	|	$autoload['config'] = array('config1', 'config2');
	|
	| NOTE: This item is intended for use ONLY if you have created custom
	| config files.  Otherwise, leave it blank.
	|
	*/
	$autoload['config'] = array();

	/*
	| -------------------------------------------------------------------
	|  Auto-load Language files
	| -------------------------------------------------------------------
	| Prototype:
	|
	|	$autoload['language'] = array('lang1', 'lang2');
	|
	| NOTE: Do not include the "_lang" part of your file.  For example
	| "codeigniter_lang.php" would be referenced as array('codeigniter');
	|
	*/
	$autoload['language'] = array();

	/*
	| -------------------------------------------------------------------
	|  Auto-load Models
	| -------------------------------------------------------------------
	| Prototype:
	|
	|	$autoload['model'] = array('first_model', 'second_model');
	|
	| You can also supply an alternative model name to be assigned
	| in the controller:
	|
	|	$autoload['model'] = array('first_model' => 'first');
	*/
	$autoload['model'] = array();

/* End of file autoload.php */
/* Location: ./application/config/autoload.php */