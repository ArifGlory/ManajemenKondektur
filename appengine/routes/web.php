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

Route::get('/pesantren', 'Back\PesantrenController@index')->middleware('auth')->name('pesantren');
Route::group([
    'prefix' => 'pesantren',
    'middleware' => ['auth']
], function () {
    Route::get('data', [\App\Http\Controllers\Back\PesantrenController::class, 'data'])->name('pesantren.data');
    Route::get('trash', [\App\Http\Controllers\Back\PesantrenController::class, 'trash'])->name('pesantren.trash');
    Route::post('restore/{rs}', [\App\Http\Controllers\Back\PesantrenController::class, 'restore'])->name('pesantren.restore');
    Route::post('resetpass/{res}', [\App\Http\Controllers\Back\PesantrenController::class, 'resetpass'])->name('pesantren.resetpass');
    Route::get('add-saldo/{pesantren}', [\App\Http\Controllers\Back\PesantrenController::class, 'addSaldo'])->name('pesantren.add-saldo');
    Route::post('store-saldo', [\App\Http\Controllers\Back\PesantrenController::class, 'storeSaldo'])->name('pesantren.store-saldo');
});
Route::resource('pesantren', 'Back\PesantrenController')->middleware('auth');

Route::group([
    'prefix' => 'setting',
    'middleware' => ['auth']
], function () {
    Route::get('', [\App\Http\Controllers\Back\SettingController::class, 'index'])->name('setting.index');
    Route::post('setting', [\App\Http\Controllers\Back\SettingController::class, 'store'])->name('setting.store');
});

Route::get('/kelas', 'Back\KelasController@index')->middleware('auth')->name('kelas');
Route::group([
    'prefix' => 'kelas',
    'middleware' => 'auth'
], function () {
    Route::get('data', [\App\Http\Controllers\Back\KelasController::class, 'data'])->name('kelas.data');
    Route::get('trash', [\App\Http\Controllers\Back\KelasController::class, 'trash'])->name('kelas.trash');
    Route::post('restore/{kelas}', [\App\Http\Controllers\Back\KelasController::class, 'restore'])->name('kelas.restore');
    Route::get('remove-santri/{id_isi_kelas}', [\App\Http\Controllers\Back\KelasController::class, 'removeSantri'])->name('kelas.remove-santri');
    Route::get('add-santri/{id_kelas}', [\App\Http\Controllers\Back\KelasController::class, 'addSantri'])->name('kelas.add-santri');
    Route::post('store-santri', [\App\Http\Controllers\Back\KelasController::class, 'storeSantri'])->name('kelas.store-santri');
});
Route::resource('kelas', 'Back\KelasController')->middleware('auth');

Route::get('/santri', 'Back\SantriController@index')->middleware('auth')->name('santri');
Route::group([
    'prefix' => 'santri',
    'middleware' => 'auth'
], function () {
    Route::get('data', [\App\Http\Controllers\Back\SantriController::class, 'data'])->name('santri.data');
    Route::get('create-multi', [\App\Http\Controllers\Back\SantriController::class, 'createMulti'])->name('santri.create-multi');
    Route::post('store-multi', [\App\Http\Controllers\Back\SantriController::class, 'storeMulti'])->name('santri.store-multi');
    Route::get('trash', [\App\Http\Controllers\Back\SantriController::class, 'trash'])->name('santri.trash');
    Route::post('restore/{santri}', [\App\Http\Controllers\Back\SantriController::class, 'restore'])->name('santri.restore');
    Route::get('aktivasi/{santri}', [\App\Http\Controllers\Back\SantriController::class, 'aktivasi'])->name('santri.aktivasi');
});
Route::resource('santri', 'Back\SantriController')->middleware('auth');

Route::get('/pelanggaran', 'Back\PelanggaranController@index')->middleware('auth')->name('pelanggaran');
Route::group([
    'prefix' => 'pelanggaran',
    'middleware' => 'auth'
], function () {
    Route::get('data', [\App\Http\Controllers\Back\PelanggaranController::class, 'data'])->name('pelanggaran.data');
    Route::get('make/{id_santri}', [\App\Http\Controllers\Back\PelanggaranController::class, 'make'])->name('pelanggaran.make');
    Route::get('hapus/{id_pelanggaran}', [\App\Http\Controllers\Back\PelanggaranController::class, 'hapus'])->name('pelanggaran.hapus');
});
Route::resource('pelanggaran', 'Back\PelanggaranController')->middleware('auth');

Route::get('/kitab', 'Back\KitabController@index')->middleware('auth')->name('kitab');
Route::group([
    'prefix' => 'kitab',
    'middleware' => 'auth'
], function () {
    Route::get('data', [\App\Http\Controllers\Back\KitabController::class, 'data'])->name('kitab.data');
    Route::get('add-santri/{id_kitab}', [\App\Http\Controllers\Back\KitabController::class, 'make'])->name('kitab.add-santri');
    Route::get('make-multi/{id_kitab}', [\App\Http\Controllers\Back\KitabController::class, 'makeMulti'])->name('kitab.make-multi');
    Route::post('store-multi', [\App\Http\Controllers\Back\KitabController::class, 'storeMulti'])->name('kitab.store-multi');
    Route::post('store-add-santri', [\App\Http\Controllers\Back\KitabController::class, 'storeSantriToKitab'])->name('kitab.store-add-santri');
    Route::get('hapus/{id_kitab}', [\App\Http\Controllers\Back\KitabController::class, 'hapus'])->name('kitab.hapus');
    Route::get('edit-status/{id_kms}', [\App\Http\Controllers\Back\KitabController::class, 'editStatus'])->name('kitab.edit-status');
    Route::get('remove-santri/{id_kms}', [\App\Http\Controllers\Back\KitabController::class, 'removeFromKitab'])->name('kitab.remove-santri');
});
Route::resource('kitab', 'Back\KitabController')->middleware('auth');

Route::get('/jadwal', 'Back\JadwalController@index')->middleware('auth')->name('jadwal');
Route::group([
    'prefix' => 'jadwal',
    'middleware' => 'auth'
], function () {
    Route::get('data', [\App\Http\Controllers\Back\JadwalController::class, 'data'])->name('jadwal.data');
    Route::get('trash', [\App\Http\Controllers\Back\JadwalController::class, 'trash'])->name('jadwal.trash');
    Route::post('restore/{jadwal}', [\App\Http\Controllers\Back\JadwalController::class, 'restore'])->name('jadwal.restore');
});
Route::resource('jadwal', 'Back\JadwalController')->middleware('auth');

Route::get('/pembayaran', 'Back\PembayaranController@index')->middleware('auth')->name('pembayaran');
Route::group([
    'prefix' => 'pembayaran',
    'middleware' => 'auth'
], function () {
    Route::get('data', [\App\Http\Controllers\Back\PembayaranController::class, 'data'])->name('pembayaran.data');
    Route::get('trash', [\App\Http\Controllers\Back\PembayaranController::class, 'trash'])->name('pembayaran.trash');
    Route::post('restore/{pembayaran}', [\App\Http\Controllers\Back\PembayaranController::class, 'restore'])->name('pembayaran.restore');
});
Route::resource('pembayaran', 'Back\PembayaranController')->middleware('auth');

Route::get('/wali-santri', 'Back\OrangTuaController@index')->middleware('auth')->name('wali-santri');
Route::group([
    'prefix' => 'wali-santri',
    'middleware' => 'auth'
], function () {
    Route::get('data', [\App\Http\Controllers\Back\OrangTuaController::class, 'data'])->name('wali-santri.data');
    Route::get('trash', [\App\Http\Controllers\Back\OrangTuaController::class, 'trash'])->name('wali-santri.trash');
    Route::post('restore/{wali-santri}', [\App\Http\Controllers\Back\OrangTuaController::class, 'restore'])->name('wali-santri.restore');
    Route::get('create-multi', [\App\Http\Controllers\Back\OrangTuaController::class, 'createMulti'])->name('wali-santri.create-multi');
    Route::post('store-multi', [\App\Http\Controllers\Back\OrangTuaController::class, 'storeMulti'])->name('wali-santri.store-multi');
});
Route::resource('wali-santri', 'Back\OrangTuaController')->middleware('auth');

Route::get('/prestasi', 'Back\PrestasiController@index')->middleware('auth')->name('prestasi');
Route::group([
    'prefix' => 'prestasi',
    'middleware' => 'auth'
], function () {
    Route::get('data', [\App\Http\Controllers\Back\PrestasiController::class, 'data'])->name('prestasi.data');
    Route::get('trash', [\App\Http\Controllers\Back\PrestasiController::class, 'trash'])->name('prestasi.trash');
    Route::post('restore/{prestasi}', [\App\Http\Controllers\Back\PrestasiController::class, 'restore'])->name('prestasi.restore');
    Route::get('remove-santri/{id_isi_prestasi}', [\App\Http\Controllers\Back\PrestasiController::class, 'removeSantri'])->name('prestasi.remove-santri');
});
Route::resource('prestasi', 'Back\PrestasiController')->middleware('auth');

Route::get('/log-saldo', 'Back\LogSaldoController@index')->middleware('auth')->name('log-saldo');
Route::group([
    'prefix' => 'log-saldo',
    'middleware' => 'auth'
], function () {
    Route::get('data', [\App\Http\Controllers\Back\LogSaldoController::class, 'data'])->name('log-saldo.data');
    Route::get('trash', [\App\Http\Controllers\Back\LogSaldoController::class, 'trash'])->name('log-saldo.trash');
});
Route::resource('log-saldo', 'Back\LogSaldoController')->middleware('auth');

Route::get('/cloud_message', 'Back\CloudMessageController@index')->middleware('auth')->name('cloud_message');
Route::group([
    'prefix' => 'cloud_message',
    'middleware' => 'auth'
], function () {
    Route::get('data', [\App\Http\Controllers\Back\CloudMessageController::class, 'data'])->name('cloud_message.data');
    Route::post('send', [\App\Http\Controllers\Back\CloudMessageController::class, 'send'])->name('cloud_message.send');
});
Route::resource('cloud_message', 'Back\CloudMessageController')->middleware('auth');