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
    return $router->app->version();
});

$router->get('key', function () {
    return \Illuminate\Support\Str::random(32);
});

$router->post('login', 'AuthController@checkLogin');

/*
| To assign middleware to all routes within a group,
| you may use the middleware key in the group attribute array.
| Middleware will be executed in the order you define this array:
*/
$router->group(['middleware' => 'JwtMiddleware'], function () use ($router) {
    
    $router->get('user/show', 'UserController@show');
    $router->post('user/store', 'UserController@store');
    // $router->get('user', 'UserController@index');
});