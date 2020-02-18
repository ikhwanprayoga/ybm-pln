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
    return redirect()->route('login');
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/blank', function () {
    return Helpers::kategoriPembukuan();
    return view('blank');
});

Route::get('salin-data', 'SalinDataController@salin');

Route::get('beranda', 'BerandaController@index')->middleware('auth')->name('beranda');

Route::group(['prefix' => 'pembukuan', 'middleware' => ['auth']], function () {
    Route::get('/{slug}', 'PembukuanController@index')->name('pembukuan');
    Route::post('/{slug}/store', 'PembukuanController@store')->name('pembukuan.kas.store');
    Route::get('/{id}/edit', 'PembukuanController@edit')->name('pembukuan.kas.edit');
    Route::post('/{id}/update', 'PembukuanController@update')->name('pembukuan.kas.update');
    Route::post('/{id}/destroy', 'PembukuanController@destroy')->name('pembukuan.kas.destroy');
});

Route::group(['prefix' => 'laporan', 'namespace' => 'Laporan', 'middleware' => ['auth']], function () {
    Route::get('arus-dana', 'ArusDanaController@index')->name('laporan.arus-dana');
    Route::post('arus-dana', 'ArusDanaController@index')->name('laporan.arus-dana');
    //statistik penyaluran dana
    Route::get('statistik-penyaluran', 'StatistikPenyaluranController@index')->name('laporan.statistik-penyaluran');
    Route::post('statistik-penyaluran', 'StatistikPenyaluranController@index')->name('laporan.statistik-penyaluran');
    //rekap penyaluran
    Route::get('rekap-penyaluran-rinci', 'RekapPenyaluranController@rinci')->name('laporan.rekap-penyaluran-rinci');
    Route::post('rekap-penyaluran-rinci', 'RekapPenyaluranController@rinci')->name('laporan.rekap-penyaluran-rinci');
    Route::get('rekap-penyaluran-penerima', 'RekapPenyaluranController@penerima')->name('laporan.rekap-penyaluran-penerima');
    Route::post('rekap-penyaluran-penerima', 'RekapPenyaluranController@penerima')->name('laporan.rekap-penyaluran-penerima');
    //penerimaan data
    Route::get('penerimaan-dana', 'PenerimaanDanaController@index')->name('laporan.penerimaan-dana');
    Route::post('penerimaan-dana', 'PenerimaanDanaController@index')->name('laporan.penerimaan-dana');
});

Route::group(['prefix' => 'master' , 'namespace' => 'Master', 'middleware' => ['auth']], function () {
    Route::resource('pembukuan', 'PembukuanController');
    Route::resource('ashnaf', 'AshnafController');
    Route::resource('program', 'ProgramController');
    Route::resource('periode', 'PeriodeController');
    Route::post('periode/change', 'PeriodeController@change')->name('periode.ubah.status');
    Route::get('periode/cek/status', 'PeriodeController@cek_status')->name('periode.cek.status');
});
