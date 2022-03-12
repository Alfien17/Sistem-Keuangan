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

Route::get('/', 'AuthController@showFormLogin')->name('login');
Route::get('login', 'AuthController@showFormLogin')->name('login');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout')->name('logout');
Route::get('signup', 'AuthController@showFormRegister')->name('signup');
Route::post('postsignup', 'AuthController@register')->name('postsignup');
Route::post('/password', 'AuthController@editpsw');
Route::get('/update-password/{encrypt_id}', 'AuthController@password')->name('update');
Route::get('/verifikasi/{encrypt_id}', 'AuthController@verifikasi')->name('verif');
Route::post('/postpassword/{id}', 'AuthController@postpassword');
Route::post('/postverif/{id}', 'AuthController@postverif');

Route::group(['middleware' => ['auth', 'bagian1']], function () 
{
    // Cashier dan Accounting
    Route::post('/addakun', 'AkunController@addakun');
    Route::put('/editakun/{id}', 'AkunController@eakun');
    Route::delete('/dakun/{id}', 'AkunController@dakun');

    Route::post('/addkat-akun', 'AkunController@addkatakun');
    Route::put('/editkat-akun/{id}', 'AkunController@ekatakun');
    Route::delete('/dkat-akun/{id}', 'AkunController@dkatakun');

    Route::post('/addkas', 'BukuKasController@addkas');
    Route::put('/editkas/{id}', 'BukuKasController@ekas');
    Route::delete('/dkas/{id}', 'BukuKasController@dkas');

    Route::post('/addkategori', 'KategoriController@addkat');
    Route::put('/editkategori/{id}', 'KategoriController@ekat');
    Route::delete('/dkat/{id}', 'KategoriController@dkat');

    Route::get('/main/keuangan/tambah', 'KeuanganController@addkeu')->name('keu');
    Route::post('/tambah', 'KeuanganController@postaddkeu');
    Route::get('/main/keuangan/update/{id}', 'KeuanganController@editkeu')->name('rekap');
    Route::post('/updatekeu/{id}', 'KeuanganController@postupdatekeu');
    Route::delete('/drekap/{id}', 'KeuanganController@drekap');

    Route::get('/main/reset-data', 'MainController@reset')->name('reset');
    Route::post('/deleteakun', 'AkunController@delakun');
    Route::post('/deletekas', 'BukuKasController@delkas');
    Route::post('/deletekat', 'KategoriController@delkat');
    Route::post('/deletekeu', 'KeuanganController@delkeu');
});

Route::group(['middleware' => ['auth', 'bagian2']], function () 
{
    // Hanya Accounting
    Route::get('/main/laporan-jurnal', 'LaporanController@pilihjurnal')->name('jurnal');
    Route::post('/main/laporan-jurnal/view', 'LaporanController@jurnal')->name('jurnal');
    Route::get('/main/laporan-akun', 'LaporanController@pilihakun')->name('lakun');
    Route::post('/main/laporan-akun/view', 'LaporanController@postpilihakun')->name('lakun');
    Route::get('/main/laporan-kas', 'LaporanController@pilihbkkas')->name('lkas');
    Route::post('/main/laporan-kas/view', 'LaporanController@postpilihbkkas')->name('lkas');
    Route::get('/main/laporan-neracasaldo', 'LaporanController@pilihnersal')->name('nersal');
    Route::post('/main/laporan-neracasaldo/view', 'LaporanController@nersal')->name('nersal');
});

Route::group(['middleware' => ['auth', 'bagian3']], function () 
{
    // Hanya Admin
    Route::get('/main/datauser', 'UserController@user')->name('datauser');
    Route::get('/main/datauser/detail/{id}', 'UserController@detailuser')->name('datauser');
    Route::put('/euser/{id}', 'UserController@euser');
});

// Semua
Route::get('/main', 'MainController@main')->name('main');
Route::get('/main', 'MainController@dashboard')->name('main');
Route::get('/main/chart1', 'MainController@sortyear1')->name('main');
Route::get('/main/chart2', 'MainController@sortyear2')->name('main');
Route::get('/main/akun', 'AkunController@tambahakun')->name('dataakun');
Route::get('/main/kas', 'BukuKasController@tambahkas')->name('datakas');
Route::get('/main/kategori', 'KategoriController@tambahkat')->name('datakat');
Route::get('/main/keuangan', 'KeuanganController@rekap')->name('rekap');
Route::get('/main/keuangan/detail/{id}', 'KeuanganController@detail')->name('rekap');
Route::get('/main/help', 'MainController@help')->name('help');
Route::get('/main/profil', 'AuthController@editakun')->name('editprofil');

Route::post('/posteditakun', 'AuthController@posteditakun');
Route::post('/main/profil/imageakun/{id}', 'AuthController@imageakun')->name('imageakun');
Route::get('/dprofile/{id}', 'AuthController@dprofile');