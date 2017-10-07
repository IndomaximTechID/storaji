<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Auth API

Route::group(['prefix' => 'auth', 'namespace' => '\Api\V1'], function()
{
  Route::post('/login', [
    'as' => 'api.auth.login',
    'uses' => 'AuthController@login',
  ]);
  Route::post('/logout', [
    'as' => 'api.auth.logout',
    'middleware' => 'auth:api',
    'uses' => 'AuthController@logout',
  ]);
  Route::get('/detail', [
    'as' => 'api.auth.detail',
    'middleware' => 'auth:api',
    'uses' => 'AuthController@detail',
  ]);
});


Route::group(['prefix' => 'products', 'namespace' => '\Api\V1'], function()
{
  Route::get('/', [
    'as' => 'api.products.list',
    'middleware' => 'auth:api',
    'uses' => 'ProductController@get',
  ]);
  Route::post('/add', [
    'as' => 'api.products.add',
    'middleware' => 'auth:api',
    'uses' => 'ProductController@add',
  ]);

  // Product Types Route
  Route::group(['prefix' => 'types'], function()
  {
    Route::get('/', [
      'as' => 'api.products.types.list',
      'middleware' => 'auth:api',
      'uses' => 'ProductTypeController@get',
    ]);
    Route::get('/{id}', [
      'as' => 'api.products.types.find',
      'middleware' => 'auth:api',
      'uses' => 'ProductTypeController@find',
    ]);
  });
  Route::get('/{id}', [
    'as' => 'api.products.find',
    'middleware' => 'auth:api',
    'uses' => 'ProductController@find',
  ]);
  Route::put('/{id}/update', [
    'as' => 'api.products.update',
    'middleware' => 'auth:api',
    'uses' => 'ProductController@update',
  ]);
});


Route::group(['prefix' => 'customers', 'namespace' => '\Api\V1'], function()
{
  Route::get('/', [
    'as' => 'api.customers.list',
    'middleware' => 'auth:api',
    'uses' => 'CustomerController@get',
  ]);
  Route::post('/add', [
    'as' => 'api.customers.add',
    'middleware' => 'auth:api',
    'uses' => 'CustomerController@add',
  ]);
  Route::get('/{id}', [
    'as' => 'api.customers.find',
    'middleware' => 'auth:api',
    'uses' => 'CustomerController@find',
  ]);
  Route::put('/{id}/update', [
    'as' => 'api.customers.update',
    'middleware' => 'auth:api',
    'uses' => 'CustomerController@update',
  ]);
});


Route::group(['prefix' => 'orders', 'namespace' => '\Api\V1'], function()
{
  Route::get('/', [
    'as' => 'api.orders.list',
    'middleware' => 'auth:api',
    'uses' => 'OrderController@get',
  ]);
  Route::post('/add', [
    'as' => 'api.orders.add',
    'middleware' => 'auth:api',
    'uses' => 'OrderController@add',
  ]);
  Route::get('/{id}', [
    'as' => 'api.orders.find',
    'middleware' => 'auth:api',
    'uses' => 'OrderController@find',
  ]);
  Route::put('/{id}/update', [
    'as' => 'api.orders.update',
    'middleware' => 'auth:api',
    'uses' => 'OrderController@update',
  ]);
});
