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
    $app = App();
    $controller = $app->make('controllers\groovel\admin\filters\GroovelFilterController');
    return $controller->callAction('filter',array($params));

})->where('all', '.*');




