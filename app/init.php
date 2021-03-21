<?php
	
	// HEADER GGWP
	header('Access-Control-Allow-Origin: *');
	
	// SESSION GGWP
	session_start();

	const APP_PATH 		= __DIR__;
	const VIEW_PATH 	= APP_PATH . '\Views\\';
	const CACHE_PATH 	= APP_PATH . '\Cache\\';
	
	// AUTOLOAD GGWP
	require_once '../vendor/autoload.php';




	//Load Config and Helper
	require 'Config/auth.php';
	require 'Config/database.php';
	require 'Config/config.php';
	require 'Config/plugin.php';
	require 'Helper/url.php';
	require 'Helper/application.php';
	require 'web.php';