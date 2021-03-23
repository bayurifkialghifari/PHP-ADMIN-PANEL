<?php

	use App\Core\Route;

	$app 			= new Route;

	/** 
	* 	@var
	*  
	*	$app->add( 'Alamat web', 
	*				'Class yang ada dicontroller contoh `Ggwp\Anjay` or `Anjay`', 
	*				'Method class `index`', 
	* 				'Method request `post, get, put, delete`');
	*   @param
	*   Ketik '/:id/id2/id3' pada alamat web untuk mengirimkan parameter
	*/

	// Router
	$app->add('/', 'Home');
	$app->add('/role', '\Admin\CRUD');
	$app->add('/bread', '\Admin\BREAD');
	$app->add('/bread/generate', '\Admin\BREAD', 'generate', 'post');
	$app->add('/bread/generate/:table', '\Admin\BREAD', 'detail');
	$app->add('/bread/delete/:table', '\Admin\BREAD', 'delete');


	$app->run('/');
