<?php

/*
|--------------------------------------------------------------------------
| Main Route
|--------------------------------------------------------------------------
*/
Route::get('/', 'DefaultController@index');

Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@index']);
Route::post('login', 'Auth\LoginController@login');

Route::get('logout', 'Auth\LoginController@logout');

/*
|--------------------------------------------------------------------------
| Setoran Route
|--------------------------------------------------------------------------
*/
Route::get('setoran', 'SetoranController@index');

Route::get('setoran/edit', 'SetoranController@list_edit');
Route::get('setoran/edit/add', 'SetoranController@add_edit');
Route::post('setoran/edit/add', 'SetoranController@store_edit');

Route::get('setoran/qc', 'SetoranController@list_qc');