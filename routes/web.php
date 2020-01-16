<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/blank', function () {
    return Helpers::kategoriPembukuan();
    return view('blank');
});

Route::get('beranda', 'BerandaController@index')->name('beranda');

Route::group(['prefix' => 'pembukuan'], function () {
    Route::get('/{slug}', 'PembukuanController@index')->name('pembukuan');
    Route::post('/{slug}/store', 'PembukuanController@store')->name('pembukuan.kas.store');
    Route::get('/{id}/edit', 'PembukuanController@edit')->name('pembukuan.kas.edit');
    Route::post('/{id}/update', 'PembukuanController@update')->name('pembukuan.kas.update');
    Route::post('/{id}/destroy', 'PembukuanController@destroy')->name('pembukuan.kas.destroy');
}); 

Route::group(['prefix' => 'master' , 'namespace' => 'Master'], function () {
    Route::resource('pembukuan', 'PembukuanController');
    Route::resource('ashnaf', 'AshnafController');
    Route::resource('program', 'ProgramController');
});