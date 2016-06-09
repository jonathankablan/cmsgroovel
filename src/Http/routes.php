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
Route::group(['middleware' => ['web']], function () {
	
	Route::get('admin',function () 
	{
		$params=null;
		$app = App();
		$controller = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\filters\GroovelFilterController');
		return $controller->callAction('filter',array($params));
	
	});
	
	
	Route::group(['prefix' => 'admin'], function () {
		Route::any('{all}', function($params)
		{
		    $app = App();
		    $controller = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\filters\GroovelFilterController');
		    return $controller->callAction('filter',array($params));
		
		})->where('all','.*');
		
	});
});

//only for apps
Route::group(['middleware' => ['web']], function () {

	//any apps
	Route::group(['prefix' => '/'], function () {
		Route::any('{all}', function($params)
		{
			$app = App();
			$controller = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\filters\GroovelFilterController');
			return $controller->callAction('filter',array($params));
	
		})->where('all','.*');
	
	});
	
});

	

