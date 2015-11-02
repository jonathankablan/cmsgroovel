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

Route::any('{all}', function($params)
{
	//\Log::info('startup filter url');
    $app = App();
    $controller = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\filters\GroovelFilterController');
    return $controller->callAction('filter',array($params));

})->where('all', '.*');




