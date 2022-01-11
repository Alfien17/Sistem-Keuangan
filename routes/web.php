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
    Route::post('/addakun', 'AkunController@addakun');
    Route::put('/editakun/{id}', 'AkunController@eakun');
    Route::delete('/dakun/{id}', 'AkunController@dakun');

    Route::post('/addkat-akun', 'AkunController@addkatakun');
    Route::put('/editkat-akun/{id}', 'AkunController@ekatakun');
    Route::delete('/dkat-akun/{id}', 'AkunController@dkatakun');

    Route::post('/addkas', 'MainController@addkas');
    Route::put('/editkas/{id}', 'MainController@ekas');
    Route::delete('/dkas/{id}', 'MainController@dkas');

    Route::post('/addkategori', 'MainController@addkat');
    Route::put('/editkategori/{id}', 'MainController@ekat');
    Route::delete('/dkat/{id}', 'MainController@dkat');

    Route::get('/main/keuangan/addin', 'KeuanganController@addin')->name('masuk');
    Route::get('/main/keuangan/addout', 'KeuanganController@addout')->name('keluar');
    Route::post('/addin', 'KeuanganController@postaddin');
    Route::post('/addout', 'KeuanganController@postaddout');
    Route::get('/main/keuangan/update/{id}', 'KeuanganController@update')->name('rekap');
    Route::post('/updatein/{id}', 'KeuanganController@postupdatein');
    Route::post('/updateout/{id}', 'KeuanganController@postupdateout');
    Route::delete('/drekap/{id}', 'KeuanganController@drekap');
    Route::post('/dimage/{id}', 'KeuanganController@dimage');
    Route::post('/eimage/{id}', 'KeuanganController@eimage');

    Route::get('/main/reset-data', 'MainController@reset')->name('reset');
    Route::post('/deleteakun', 'MainController@delakun');
    Route::post('/deletekas', 'MainController@delkas');
    Route::post('/deletekat', 'MainController@delkat');
    Route::post('/deletekeu', 'MainController@delkeu');
});

Route::group(['middleware' => ['auth', 'bagian2']], function () 
{
    Route::get('/main/laporan-jurnal', 'LaporanController@pilihjurnal')->name('jurnal');
    Route::post('/main/laporan-jurnal/view', 'LaporanController@jurnal')->name('jurnal');
    Route::get('/main/laporan-akun', 'LaporanController@pilih')->name('lakun');
    Route::post('/main/laporan-akun/view', 'LaporanController@postpilih')->name('lakun');
    Route::get('/main/laporan-kas', 'LaporanController@pilih2')->name('lkas');
    Route::post('/main/laporan-kas/view', 'LaporanController@postpilih2')->name('lkas');
    Route::get('/main/laporan-neracasaldo', 'LaporanController@pilihnersal')->name('nersal');
    Route::post('/main/laporan-neracasaldo/view', 'LaporanController@nersal')->name('nersal');
});

Route::group(['middleware' => ['auth', 'bagian3']], function () 
{
    Route::get('/main/datauser', 'UserController@user')->name('datauser');
    Route::get('/main/datauser/detail/{id}', 'UserController@detailuser')->name('datauser');
    Route::put('/euser/{id}', 'UserController@euser');
});

Route::get('/main', 'MainController@main')->name('main');
Route::get('/main', 'MainController@dashboard')->name('main');
Route::get('/main/year', 'MainController@sortyear')->name('main');
Route::get('/main/akun', 'AkunController@tambahakun')->name('dataakun');
Route::get('/main/kas', 'MainController@tambahkas')->name('datakas');
Route::get('/main/kategori', 'MainController@tambahkat')->name('datakat');
Route::get('/main/keuangan', 'KeuanganController@rekap')->name('rekap');
Route::get('/main/keuangan/detail/{id}', 'KeuanganController@detail')->name('rekap');
Route::get('/main/help', 'MainController@help')->name('help');
Route::get('/main/profil', 'EditController@editakun')->name('editprofil');

Route::post('/posteditakun', 'EditController@posteditakun');
Route::post('/main/profil/imageakun/{id}', 'EditController@imageakun')->name('imageakun');
Route::get('/dprofile/{id}', 'EditController@dprofile');

// Route::get('/main/keuangan/in-out', 'KeuanganController@multi')->name('multi');
// Route::post('/in-out', 'KeuanganController@postmulti');
