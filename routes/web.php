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

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('/', 'ApiController@index');

    $router->get('/countries', 'ApiController@countries');
    $router->get('/country/{code}', 'ApiController@country');

    $router->get('/regions', 'ApiController@regions');
    $router->get('/region/{find}/', 'ApiController@region');
    $router->get('/region/{find}/provinces', 'ApiController@regionProvinces');

    $router->get('/provinces', 'ApiController@provinces');
    $router->get('/province/{find}', 'ApiController@province');
    $router->get('/province/{find}/cities', 'ApiController@provinceCities');

    $router->get('/cities', 'ApiController@cities');
    $router->get('/city/{find}/', 'ApiController@city');
});