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
    //laporan pembukuan
    Route::get('pembukuan/{slug}', 'LaporanController@index')->name('laporan.pembukuan');
    Route::post('pembukuan/{slug}', 'LaporanController@index')->name('laporan.pembukuan');
    Route::get('pembukuan/{slug}/export/{tahun}/{bulan}', 'LaporanController@export')->name('laporan.pembukuan.export');
    //arus data
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
    //realisasi rkat
    Route::get('realisasi-rkat', 'RealisasiRkatController@index')->name('laporan.realisasi-rkat');
});

Route::group(['prefix' => 'rkat', 'middleware' => ['auth']], function () {
    Route::get('/', 'RkatController@index')->name('rkat.index');
    Route::post('{idProgram}/store', 'RkatController@store_kategori_program')->name('rkat.kategori-program.store');
    Route::post('{idRkat}/update', 'RkatController@update')->name('rkat.update');
    Route::post('{idRkat}/destroy', 'RkatController@destroy')->name('rkat.destroy');
    Route::post('{idProgram}/{idKategoriRkat}/store', 'RkatController@store_sub_kategori_program')->name('rkat.sub-kategori-program.store');
    Route::get('{idProgram}/get', 'RkatController@get_rkat_program')->name('rkat.program.get');
    Route::get('sub/{rkatId}/get', 'RkatController@get_sub_rkat_program')->name('rkat.sub.program.get');
    Route::get('get/{rkatId}', 'RkatController@get_rkat')->name('rkat.get');
});

Route::group(['prefix' => 'master' , 'namespace' => 'Master', 'middleware' => ['auth']], function () {
    Route::resource('pembukuan', 'PembukuanController');
    Route::resource('ashnaf', 'AshnafController');
    Route::resource('program', 'ProgramController');
    Route::resource('periode', 'PeriodeController');
    Route::post('periode/change', 'PeriodeController@change')->name('periode.ubah.status');
    Route::get('periode/cek/status', 'PeriodeController@cek_status')->name('periode.cek.status');
});

Route::get('tes-log', function () {
    $array = [
        'pembukuan_id' => 1,
        'user' => 'operator',
        'tipe' => 'debet',
        'aktivitas' => 'post',
        'nominal' => 1000000,
        'keterangan' => 'pemasukan'
    ];
    Log::catat($array);
});
