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
});
