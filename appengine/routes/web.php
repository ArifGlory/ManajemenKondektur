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

Auth::routes([
    'register' => false
]);

//back-end
Route::get('/', 'HomeController@dashboard')->middleware('auth')->name('dashboard');
Route::get('/dashboard', 'HomeController@dashboard')->middleware('auth')->name('dashboard');
Route::get('/cari-jadwal', 'HomeController@cariJadwal')->middleware('auth')->name('cari-jadwal');


Route::group([
    'prefix' => 'setting',
    'middleware' => ['auth']
], function () {
    Route::get('', [\App\Http\Controllers\Back\SettingController::class, 'index'])->name('setting.index');
    Route::post('setting', [\App\Http\Controllers\Back\SettingController::class, 'store'])->name('setting.store');
});

Route::get('/pegawai', 'Back\PegawaiController@index')->middleware('auth')->name('pegawai');
Route::group([
    'prefix' => 'pegawai',
    'middleware' => 'auth'
], function () {
    Route::get('data', [\App\Http\Controllers\Back\PegawaiController::class, 'data'])->name('pegawai.data');
   /* Route::get('create-multi', [\App\Http\Controllers\Back\PegawaiController::class, 'createMulti'])->name('pegawai.create-multi');
    Route::post('store-multi', [\App\Http\Controllers\Back\PegawaiController::class, 'storeMulti'])->name('pegawai.store-multi');*/
    Route::get('trash', [\App\Http\Controllers\Back\PegawaiController::class, 'trash'])->name('pegawai.trash');
    Route::post('restore/{pegawai}', [\App\Http\Controllers\Back\PegawaiController::class, 'restore'])->name('pegawai.restore');
});
Route::resource('pegawai', 'Back\PegawaiController')->middleware('auth');

Route::get('/jadwal', 'Back\JadwalController@index')->middleware('auth')->name('jadwal');
Route::group([
    'prefix' => 'jadwal',
    'middleware' => 'auth'
], function () {
    Route::get('tukar-jadwal', [\App\Http\Controllers\Back\JadwalController::class, 'listTukarJadwal'])->name('jadwal.tukar-jadwal');
    Route::get('data', [\App\Http\Controllers\Back\JadwalController::class, 'data'])->name('jadwal.data');
    Route::get('data-cari-jadwal', [\App\Http\Controllers\Back\JadwalController::class, 'dataCariJadwal'])->name('jadwal.data-cari-jadwal');
    Route::get('data-tukar-jadwal', [\App\Http\Controllers\Back\JadwalController::class, 'dataTukarJadwal'])->name('jadwal.data-tukar-jadwal');
    Route::get('tukar/{id}', [\App\Http\Controllers\Back\JadwalController::class, 'ajukanTukar'])->name('jadwal.tukar');
    Route::get('show-tukar-jadwal/{id}', [\App\Http\Controllers\Back\JadwalController::class, 'showTukarJadwal'])->name('jadwal.show-tukar-jadwal');
    Route::put('update-tukar-jadwal', [\App\Http\Controllers\Back\JadwalController::class, 'updateTukarJadwal'])->name('jadwal.update-tukar-jadwal');
    /* Route::get('create-multi', [\App\Http\Controllers\Back\JadwalController::class, 'createMulti'])->name('jadwal.create-multi');
     Route::post('store-multi', [\App\Http\Controllers\Back\JadwalController::class, 'storeMulti'])->name('jadwal.store-multi');*/
    Route::get('trash', [\App\Http\Controllers\Back\JadwalController::class, 'trash'])->name('jadwal.trash');
    Route::post('restore/{jadwal}', [\App\Http\Controllers\Back\JadwalController::class, 'restore'])->name('jadwal.restore');
    Route::post('store-penukaran', [\App\Http\Controllers\Back\JadwalController::class, 'storePenukaran'])->name('jadwal.store-penukaran');
});
Route::resource('jadwal', 'Back\JadwalController')->middleware('auth');





