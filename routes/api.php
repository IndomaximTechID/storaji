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


// Signal API
Route::get('/', function (Request $request) {
    return $request->json(['status' => 'connected']);
});
// Auth API

Route::group(['prefix' => 'auth', 'namespace' => 'Api\V1'], function()
{
  Route::post('/login', [
    'as' => 'api.auth.login',
    'uses' => 'AuthController@login',
  ]);
  Route::post('/register', [
    'as' => 'api.auth.register',
    'uses' => 'AuthController@register',
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


// Stats API
Route::group(['prefix' => 'stats', 'namespace' => 'Api\V1'], function()
{
  Route::get('/', [
    'as' => 'api.stats',
    'middleware' => 'auth:api',
    'uses' => 'StatsController@stats',
  ]);
  Route::get('/top/products', [
    'as' => 'api.stats.top.products',
    'middleware' => 'auth:api',
    'uses' => 'StatsController@topProducts',
  ]);
});


// Products API
Route::group(['prefix' => 'products', 'namespace' => 'Api\V1'], function()
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


  // Products API children Types
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
  Route::get('/{id}/customers', [
    'as' => 'api.products.customers',
    'middleware' => 'auth:api',
    'uses' => 'ProductController@customers',
  ]);
  Route::put('/{id}/update', [
    'as' => 'api.products.update',
    'middleware' => 'auth:api',
    'uses' => 'ProductController@update',
  ]);
  Route::delete('/{id}/delete', [
    'as' => 'api.products.delete',
    'middleware' => 'auth:api',
    'uses' => 'ProductController@delete',
  ]);
});


// Companies API
Route::group(['prefix' => 'companies', 'namespace' => 'Api\V1'], function()
{
  // Companies API children Types
  Route::group(['prefix' => 'types'], function()
  {
    Route::get('/', [
      'as' => 'api.companies.types.list',
      'uses' => 'CompanyTypeController@get',
    ]);
    Route::get('/{id}', [
      'as' => 'api.companies.types.find',
      'uses' => 'CompanyTypeController@find',
    ]);
  });
});


// Users API
Route::group(['prefix' => 'users', 'namespace' => 'Api\V1'], function()
{
  Route::put('/profile', [
    'as' => 'api.users.profile.update',
    'middleware' => 'auth:api',
    'uses' => 'UserController@updateProfile',
  ]);
});


// Customers API
Route::group(['prefix' => 'customers', 'namespace' => 'Api\V1'], function()
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
  Route::delete('/{id}/delete', [
    'as' => 'api.customers.delete',
    'middleware' => 'auth:api',
    'uses' => 'CustomerController@delete',
  ]);
});


// Orders API
Route::group(['prefix' => 'orders', 'namespace' => 'Api\V1'], function()
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
  Route::delete('/{id}/delete', [
    'as' => 'api.orders.delete',
    'middleware' => 'auth:api',
    'uses' => 'OrderController@delete',
  ]);
});
