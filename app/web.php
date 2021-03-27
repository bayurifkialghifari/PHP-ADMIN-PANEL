<?php

	use App\Models\Bread;
	use App\Core\Route;

	$app 			= new Route;
	$bread 			= Bread::all();

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


	// Bread route
	foreach($bread as $b)
	{
		$controller = $b['controller'] == '' ? '\Admin\CRUD' : $b['controller'];

		$app->add('/admin/'.$b['slug'], $controller);
		$app->add('/admin/'.$b['slug'].'-create', $controller, 'create', 'post');
		$app->add('/admin/'.$b['slug'].'-update', $controller, 'update', 'put');
		$app->add('/admin/'.$b['slug'].'-delete', $controller, 'delete', 'delete');
	}


	$app->run('/');
