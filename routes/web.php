<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/main', 'MainController@main')->name('main');
Route::get('/main', 'MainController@dashboard')->name('main');
Route::get('/main/year', 'MainController@sortyear');

Route::get('/main/akun', 'MainController@tambahakun')->name('dataakun');
Route::post('/addakun', 'MainController@addakun');
Route::put('/editakun/{id}', 'MainController@eakun');
Route::delete('deleteakun', 'MainController@deleteakun');
Route::delete('/dakun/{id}', 'MainController@dakun');
Route::get('/searchakun', 'MainController@searchakun');

Route::get('/main/kas', 'MainController@tambahkas')->name('datakas');
Route::post('/addkas', 'MainController@addkas');
Route::put('/editkas/{id}', 'MainController@ekas');
Route::delete('deletekas', 'MainController@deletekas');
Route::delete('/dkas/{id}', 'MainController@dkas');
Route::get('/searchkas', 'MainController@searchkas');

Route::get('/main/kategori', 'MainController@tambahkat')->name('datakat');
Route::post('/addkategori', 'MainController@addkat');
Route::put('/editkategori/{id}', 'MainController@ekat');
Route::delete('deletekat', 'MainController@deletekat');
Route::delete('/dkat/{id}', 'MainController@dkat');
Route::get('/searchkategori', 'MainController@searchkat');

Route::get('/main/keuangan', 'KeuanganController@rekap');
Route::get('/main/keuangan/addin', 'KeuanganController@addin');
Route::get('/main/keuangan/addout', 'KeuanganController@addout');
Route::post('/addin', 'KeuanganController@postaddin');
Route::post('/addout', 'KeuanganController@postaddout');
Route::get('/main/keuangan/update/{id}', 'KeuanganController@update');
Route::post('/updatein/{id}', 'KeuanganController@postupdatein');
Route::post('/updateout/{id}', 'KeuanganController@postupdateout');
Route::delete('deleterekap', 'KeuanganController@deleterekap');
Route::delete('/drekap/{id}', 'KeuanganController@drekap');
Route::get('/main/keuangan/detail/{id}', 'KeuanganController@detail');
Route::get('/searchrekap', 'KeuanganController@searchrekap');
Route::get('/dimage/{id}', 'KeuanganController@dimage');
Route::post('/eimage/{id}', 'KeuanganController@eimage');

Route::get('/autocompleteakun', 'KeuanganController@acakun')->name('autocompleteakun');
Route::get('/autocompleteakun2', 'KeuanganController@acakun2')->name('autocompleteakun2');
Route::get('/autocompleteakun3', 'KeuanganController@acakun3')->name('autocompleteakun3');
Route::get('/autocompletekas', 'KeuanganController@ackas')->name('autocompletekas');
Route::get('/autocompletekat', 'KeuanganController@ackat')->name('autocompletekat');

Route::get('/main/jurnal', 'LaporanController@jurnal')->name('jurnal');
Route::get('/main/laporan-specific', 'LaporanController@pilih');
Route::post('/main/laporan-specific/view', 'LaporanController@postpilih');

Route::get('/main/reset-data', 'MainController@reset');
Route::post('/deleteakun', 'MainController@delakun');
Route::post('/deletekas', 'MainController@delkas');
Route::post('/deletekat', 'MainController@delkat');
Route::post('/deletekeu', 'MainController@delkeu');

Route::get('/main/keuangan/addout', 'KeuanganController@addout');
Route::post('/addout', 'KeuanganController@postaddout');


