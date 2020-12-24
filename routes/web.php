<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return Carbon\Carbon::now()->toDateTimeString();
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login',['uses' => 'AuthController@authenticate']);
    $router->post('register',['uses' => 'AuthController@register']);
});

$router->group(['prefix' => 'session'], function() use ($router) {
    $router->get('',['uses' => 'SessionController@index']);
    $router->get('/{id}',['uses' => 'SessionController@getId']);
    $router->group(['middleware'=>'jwt.auth'], function() use ($router) {
        $router->post('create',['uses' => 'SessionController@create']);
        $router->patch('update/{id}',['uses' => 'SessionController@update']);
        $router->get('delete/{id}',['uses' => 'SessionController@delete']);
    });
});
