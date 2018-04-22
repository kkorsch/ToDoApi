<?php

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

Route::post( '/register', 'AuthController@register' );
Route::post( '/signin', 'AuthController@signIn' );

Route::group( ['middleware' => 'jwt.auth'], function() {
  Route::get( '/list', 'TaskListController@index' );
  Route::get( '/list/{list}', 'TaskListController@show' );
  Route::post( '/list', 'TaskListController@store' );
  Route::put( '/list/{list}', 'TaskListController@update' );
  Route::delete( '/list/{list}', 'TaskListController@destroy' );

  Route::post( '/list/{list}/task', 'TaskController@store' );
  Route::patch( '/list/{list}/task/{task}', 'TaskController@update' );
  Route::delete( '/list/{list}/task/{task}', 'TaskController@destroy' );
});
