<?php

/*
|--------------------------------------------------------------------------
| Order Route
|--------------------------------------------------------------------------
*/
if(config('app.env') == 'local') 
{
	//localhost
	Route::get('order', 'OrderController@order');
  Route::post('order/add', 'OrderController@order_add');
  Route::get('order/status/{id}/{code}', 'OrderController@status');
  Route::post('order/confirm/add', 'OrderController@add_confirm');
}
else
{
	//live version
	Route::group(['domain' => 'shop.moesubs.com'], function(){
	  Route::get('/', 'OrderController@order');
	  Route::post('order/add', 'OrderController@order_add');
  Route::get('order/status/{id}/{code}', 'OrderController@status');
		// Route::get('order', 'OrderController@order');
	});
}

/*
|--------------------------------------------------------------------------
| Main Default Route (Dasbor and Auth)
|--------------------------------------------------------------------------
*/
Route::get('/', 'DefaultController@index');
Route::get('dasbor', 'DefaultController@index');
Route::get('home', 'DefaultController@index');

Route::get('tests', 'DefaultController@tests');

Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@index']);
Route::post('login', 'Auth\LoginController@login');

Route::get('logout', 'Auth\LoginController@logout');

Route::post('contact/send', 'DefaultController@contact_send');

/*
|--------------------------------------------------------------------------
| Rilisan Route
|--------------------------------------------------------------------------
*/

Route::get('rilisan', 'RilisanController@index');
Route::get('rilisan/add', 'RilisanController@add');
Route::post('rilisan/add', 'RilisanController@store');
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

/*
|--------------------------------------------------------------------------
| Shops Route
|--------------------------------------------------------------------------
*/
Route::get('shops', 'ShopsController@index');
Route::get('shops/detail/{id}', 'ShopsController@detail');
Route::get('shops/add', 'ShopsController@add');
Route::post('shops/add', 'ShopsController@store');
Route::get('shops/edit/{id}', 'ShopsController@edit');
Route::post('shops/edit', 'ShopsController@update');
Route::post('shops/delete', 'ShopsController@delete');
Route::post('shops/detail/approved', 'ShopsController@approve');
Route::get('shops/detail/{id}/buyer/{code}', 'ShopsController@buyer');