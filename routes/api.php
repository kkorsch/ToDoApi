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
  Route::get( '/lists', 'TaskListController@index' );
  Route::post( '/lists', 'TaskListController@store' );
  Route::put( '/lists/{list}', 'TaskListController@update' );
  Route::delete( '/lists/{list}', 'TaskListController@destroy' );

  Route::post( '/lists/{list}/task', 'TaskController@store' );
  Route::patch( '/lists/{list}/task/{task}', 'TaskController@update' );
});
