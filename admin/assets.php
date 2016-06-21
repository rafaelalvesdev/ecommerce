<?php
	
	require_once 'helpers/JSMinifier.Class.php';

	if(!isset($_REQUEST['type'])){
		exit();
	}

	define('ASSET_TYPE', strtolower($_REQUEST['type']));
	define('TYPE_JS', 'js');
	define('TYPE_CSS', 'css');

	switch (ASSET_TYPE) {
		case TYPE_JS:
			header('Content-Type:text/javascript');
			define('CACHE_FILE', 'script.js');
			define('SOURCE_FOLDER', TYPE_JS);
		break;
		
		case TYPE_CSS:
			header('Content-Type:text/css');
			define('CACHE_FILE', 'style.css');
			define('SOURCE_FOLDER', TYPE_CSS);
		break;

		default:
			exit();
		break;
	}

	define('CACHE_FOLDER', 'cache');
	define('DS', '/');

	if(!file_exists(CACHE_FOLDER)){
		mkdir(CACHE_FOLDER);
	}
	
	if(!file_exists(CACHE_FOLDER . DS . CACHE_FILE)){

		$files = array();
		$dir = opendir(SOURCE_FOLDER);

		while(false != ($file = readdir($dir))) {
		    if(($file != ".") && ($file != "..")) {
				$files[] = $file;
		    }   
		}

		natsort($files);

		$data = '';
		foreach($files as $file) {
			$data .= file_get_contents(SOURCE_FOLDER . DS . $file) . PHP_EOL . PHP_EOL;			
		}

		if(ASSET_TYPE == TYPE_JS){
			//$data = JSMinifier::minify($data);
		}

		if(ASSET_TYPE == TYPE_CSS){
			$data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $data);
			$data = str_replace(': ', ':', $data);
			$data = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $data);
		}

		//file_put_contents(CACHE_FOLDER . DS . CACHE_FILE, $data);

		exit($data);
	}


	if(file_exists(CACHE_FOLDER . DS . CACHE_FILE)){
		//readfile(CACHE_FOLDER . DS . CACHE_FILE);
	}
	ob_start("ob_gzhandler");