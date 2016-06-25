<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


// for backend groovel
Route::group(['middleware' => ['web','groovel.filter','groovel.userrules']], function () {
	
	Route::get('admin',function () 
	{
		$params=null;
		$app = App();
		$controller = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController');
		return $controller->callAction('dispatcher',array($params));
	
	});
	
	
	Route::group(['prefix' => 'admin'], function () {
		Route::any('{all}', function($params)
		{
		    $app = App();
		   	$controller = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController');
			return $controller->callAction('dispatcher',array($params));
		
		})->where('all','.*');
		
	});
});

//only for apps
Route::group(['middleware' => ['web','groovel.filter','groovel.userrules','groovel.contents','groovel.layouts']], function () {
	//any apps
	Route::group(['prefix' => '/'], function () {
		Route::any('{all}', function($params)
		{
			$app = App();
			$controller = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController');
			return $controller->callAction('dispatcher',array($params));
	
		})->where('all','.*');
	
	});
	
});

	

