<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('login', [
'as' => 'login', 'uses' => 'ReynielController@page']);

$router->post('validation', [
'as' => 'validation', 'uses' => 'ReynielController@verify' ]);

$router->get('dashboard', [
'as' => 'dashboard', 'uses' => 'ReynielController@crud']);

$router->get('registerBus', [
'as' => 'registerBus', 'uses' => 'ReynielController@registerBus']);

$router->get('driver_conductor', [
'as' => 'driver_conductor', 'uses' => 'ReynielController@driver_conductor']);

$router->post('addDriver', [
'as' => 'addDriver', 'uses' => 'ReynielController@addDriver']);

$router->post('addConductor', [
'as' => 'addConductor', 'uses' => 'ReynielController@addConductor']);

$router->post('deleteDriver', [
'as' => 'deleteDriver', 'uses' => 'ReynielController@deleteDriver']);

$router->post('deleteConductor', [
'as' => 'deleteConductor', 'uses' => 'ReynielController@deleteConductor']);

$router->post('editDriver', [
'as' => 'editDriver', 'uses' => 'ReynielController@editDriver']);

$router->post('editConductor', [
'as' => 'editConductor', 'uses' => 'ReynielController@editConductor']);


$router->post('editBusReg', [
'as' => 'editBusReg', 'uses' => 'ReynielController@editBusReg']);

$router->get('busRoute', [
'as' => 'busRoute', 'uses' => 'ReynielController@busRoute']);


$router->post('addRoute', [
'as' => 'addRoute', 'uses' => 'ReynielController@addRoute']);

$router->post('editRoute', [
'as' => 'editRoute', 'uses' => 'ReynielController@editRoute']);

$router->post('deleteRoute', [
'as' => 'deleteRoute', 'uses' => 'ReynielController@deleteRoute']);

$router->post('deleteUser', [
'as' => 'deleteUser', 'uses' => 'ReynielController@deleteUser']);

$router->post('deleteRegBus', [
'as' => 'deleteRegBus', 'uses' => 'ReynielController@deleteRegBus']);

$router->post('addBus', [
'as' => 'addBus', 'uses' => 'ReynielController@addBus']);

$router->post('addBusOwner', [
'as' => 'addBusOwner', 'uses' => 'ReynielController@addBusOwner']);

$router->post('addRegBus', [
'as' => 'addRegBus', 'uses' => 'ReynielController@addRegBus']);