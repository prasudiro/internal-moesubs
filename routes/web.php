<?php

/*
|--------------------------------------------------------------------------
| Main Route (Dasbor and Auth)
|--------------------------------------------------------------------------
*/
Route::get('/', 'DefaultController@index');
Route::get('dasbor', 'DefaultController@index');
Route::get('home', 'DefaultController@index');

Route::get('tests', 'DefaultController@tests');

Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@index']);
Route::post('login', 'Auth\LoginController@login');

Route::get('logout', 'Auth\LoginController@logout');

/*
|--------------------------------------------------------------------------
| Rilisan Route
|--------------------------------------------------------------------------
*/

Route::get('rilisan', 'RilisanController@index');
Route::get('rilisan/edit/{id}', 'RilisanController@edit');
Route::post('rilisan/update', 'RilisanController@update');

/*
|--------------------------------------------------------------------------
| Kategori Route
|--------------------------------------------------------------------------
*/

Route::get('kategori', 'KategoriController@index');
Route::get('kategori/add', 'KategoriController@add');
Route::post('kategori/add', 'KategoriController@store');

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

/*
|--------------------------------------------------------------------------
| Pengaturan Route
|--------------------------------------------------------------------------
*/
Route::get('pengaturan', 'PengaturanController@index');
Route::get('pengaturan/notifikasi', 'PengaturanController@notifikasi');
Route::post('pengaturan/notifikasi', 'PengaturanController@notifikasi_save');