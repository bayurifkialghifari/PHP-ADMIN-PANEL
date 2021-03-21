<?php
	
	use eftec\bladeone\BladeOne;

	function view($view, $data = [])
	{
		// Views folder
		$views 					= VIEW_PATH;
		// Cache folder
		$cache 					= CACHE_PATH;

		$blade 					= new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

		// Replace /\
		$view 					= str_replace('/', '\\', $view);

		echo $blade->run($view, $data);
	}

	function view_html_only($view, $data = [])
	{
		ob_start();

		view($view, $data);

		return ob_get_clean();
	}

	function load_helper($helper, $data = [])
	{
		// Array key to new variable
		extract($data, EXTR_PREFIX_SAME, "wddx");

		$data 					= [];

		require_once '../app/Helper/' . $helper . '.php';
	}

	function load_config($config, $data = [])
	{
		// Array key to new variable
		extract($data, EXTR_PREFIX_SAME, "wddx");

		$data 					= [];

		require_once '../app/Config/' . $config . '.php';
	}

	function nominal($number)
	{
	    $nominal 	= number_format($number,0,',','.');
	    
	    return $nominal;
	}

	function alert($message)
	{
		echo "<script>alert('{$message}')</script>";
	}