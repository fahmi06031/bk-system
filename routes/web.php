<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HasilPrediksiController;
use App\Http\Controllers\PrediksiRisikoController;
use App\Http\Controllers\LandingController;


/*
|--------------------------------------------------------------------------
| LANDING PAGE (PUBLIC)
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index']);
Route::post('/', [LandingController::class, 'cari']);


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/login', [AuthController::class,'authenticate']);
Route::get('/logout', [AuthController::class,'logout']);


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('admin')->group(function () {

    Route::get('/dashboard',[AdminController::class,'dashboard']);

    Route::get('/siswa',[SiswaController::class,'index']);
    Route::post('/siswa',[SiswaController::class,'store']);
    Route::put('/siswa/{id}',[SiswaController::class,'update']);
    Route::delete('/siswa/{id}',[SiswaController::class,'destroy']);

    Route::get('/guru',[GuruController::class,'index']);
    Route::post('/guru',[GuruController::class,'store']);
    Route::put('/guru/{id}',[GuruController::class,'update']);
    Route::delete('/guru/{id}',[GuruController::class,'destroy']);

    Route::get('/kelas',[KelasController::class,'index']);
    Route::post('/kelas',[KelasController::class,'store']);

    Route::get('/mata-pelajaran',[MataPelajaranController::class,'index']);
    Route::post('/mata-pelajaran',[MataPelajaranController::class,'store']);
    Route::put('/mata-pelajaran/{id}',[MataPelajaranController::class,'update']);
    Route::delete('/mata-pelajaran/{id}',[MataPelajaranController::class,'destroy']);

    Route::get('/pelanggaran',[PelanggaranController::class,'index']);
    Route::post('/pelanggaran',[PelanggaranController::class,'store']);

    Route::get('/prediksi-risiko',[PrediksiRisikoController::class,'index']);
    Route::post('/prediksi-risiko/proses',[PrediksiController::class,'proses']);

    Route::get('/hasil-prediksi',[HasilPrediksiController::class,'index']);
    Route::delete('/hasil-prediksi/{id}',[HasilPrediksiController::class,'destroy']);
    Route::post('/prediksi-risiko/simpan',[HasilPrediksiController::class,'simpan']);

});


/*
|--------------------------------------------------------------------------
| USER (SISWA)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('user')->group(function () {

    Route::get('/dashboard',[UserController::class,'dashboard']);
    Route::get('/profil',[UserController::class,'profil']);
    Route::get('/hasil-prediksi',[UserController::class,'hasilPrediksi']);

});
