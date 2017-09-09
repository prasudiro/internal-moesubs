<?php

/*
|--------------------------------------------------------------------------
| Main Route (Dasbor and Auth)
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
Route::get('setoran/download/{id}', 'SetoranController@download_setoran');
Route::post('setoran/delete', 'SetoranController@delete_setoran');

//Setoran Edit
Route::get('setoran/edit', 'SetoranController@list_edit');
Route::get('setoran/edit/add', 'SetoranController@add_edit');
Route::post('setoran/edit/add', 'SetoranController@store');

//Setoran QC
Route::get('setoran/qc', 'SetoranController@list_qc');
Route::get('setoran/qc/add', 'SetoranController@add_qc');
Route::post('setoran/qc/add', 'SetoranController@store');

/*
|--------------------------------------------------------------------------
| Laporan Route
|--------------------------------------------------------------------------
*/
Route::get('laporan', 'LaporanController@index');
Route::get('laporan/add', 'LaporanController@add');
Route::post('laporan/add', 'LaporanController@store');
Route::get('laporan/edit/{id}', 'LaporanController@edit');
Route::post('laporan/update', 'LaporanController@update');