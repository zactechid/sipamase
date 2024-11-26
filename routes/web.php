<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dataController;
use App\Http\Controllers\userController;
use App\Http\Controllers\basicController;
use App\Http\Controllers\rapatController;
use App\Http\Controllers\masterController;
use App\Http\Controllers\berandaController;
use App\Http\Controllers\pengajuanController;
use App\Http\Controllers\perancangController;
use App\Http\Controllers\penyampaianController;
use App\Http\Controllers\administrasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/download/{file?}', [basicController::class, 'downloadFile'])->where('file', '.*');
// Basic Page
Route::controller(basicController::class)->group(function() {
    Route::get('/', 'index')->middleware('guest');
    Route::get('/show/{get}', 'show')->middleware('guest');
    Route::get('/', 'index')->middleware('guest');
    Route::post('/', 'index_filter')->middleware('guest');
    Route::get('/perancang', 'perancang')->middleware('guest');
    Route::get('/login', 'login')->name('login')->middleware('guest');
    Route::post('/login', 'login_post')->middleware('guest');
    Route::get('/logout', [basicController::class, 'logout']);

    Route::get('/pengajuan/masukan/{harmonisasi:judul}', 'masukan')->middleware('guest');
    Route::post('/pengajuan/masukan/{harmonisasi:judul}', 'masukan_store')->middleware('guest');
});

Route::get('/beranda', [berandaController::class, 'index'])->middleware('auth');
Route::get('/beranda/{get}', [berandaController::class, 'show'])->middleware('auth');

// pengajuan
Route::controller(pengajuanController::class)->group(function() {
    Route::get('/pengajuan', 'index')->middleware('auth');
    Route::post('/pengajuan', 'index_filter')->middleware('auth');
    Route::get('/pengajuan/{rancangan}', 'tambah')->middleware('auth');
    Route::post('/pengajuan/{rancangan}', 'store')->middleware('auth');
    Route::get('/pengajuan/edit/{harmonisasi:judul}', 'edit')->middleware('auth');
    Route::post('/pengajuan/edit/{harmonisasi:judul}', 'update')->middleware('auth');
    Route::get('/pengajuan/destroy/{harmonisasi:judul}', 'destroy')->middleware(['auth', 'isAdmin']);

    // hapus dokumen
    Route::get('/1/{harmonisasi:judul}', 'destroy1')->middleware('auth');
    Route::get('/2/{harmonisasi:judul}', 'destroy2')->middleware('auth');
    Route::get('/3/{harmonisasi:judul}', 'destroy3')->middleware('auth');
    Route::get('/4/{harmonisasi:judul}', 'destroy4')->middleware('auth');
    Route::get('/5/{harmonisasi:judul}', 'destroy5')->middleware('auth');
});

// Administrasi Dan Analisis
Route::controller(administrasiController::class)->middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('/administrasi', 'index');
    Route::post('/administrasi', 'index_filter');
    Route::get('/administrasi/{harmonisasi:judul}', 'show');
    Route::post('/administrasi/{harmonisasi:judul}', 'update');

    // hapus dokumen
    Route::get('/1/administrasi/{harmonisasi:judul}', 'destroy1');
    Route::get('/2/administrasi/{harmonisasi:judul}', 'destroy2');
    Route::get('/3/administrasi/{harmonisasi:judul}', 'destroy3');
    Route::get('/4/administrasi/{harmonisasi:judul}', 'destroy4');
    Route::get('/5/administrasi/{harmonisasi:judul}', 'destroy5');
});

// Rapat
Route::controller(rapatController::class)->middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('/rapat', 'index');
    Route::post('/rapat', 'index_filter');
    Route::get('/rapat/{harmonisasi:judul}', 'show');
    Route::post('/rapat/{harmonisasi:judul}', 'update');

    // hapus dokumen
    Route::get('/1/rapat/{harmonisasi:judul}', 'destroy1');
    Route::get('/2/rapat/{harmonisasi:judul}', 'destroy2');
    Route::get('/3/rapat/{harmonisasi:judul}', 'destroy3');
    Route::get('/4/rapat/{harmonisasi:judul}', 'destroy4');
    Route::get('/5/rapat/{harmonisasi:judul}', 'destroy5');
});

// penyampaian
Route::controller(penyampaianController::class)->middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('/penyampaian', 'index');
    Route::post('/penyampaian', 'index_filter');
    Route::get('/penyampaian/{harmonisasi:judul}', 'show');
    Route::post('/penyampaian/{harmonisasi:judul}', 'update');

    // hapus dokumen
    Route::get('/1/penyampaian/{harmonisasi:judul}', 'destroy1');
    Route::get('/2/penyampaian/{harmonisasi:judul}', 'destroy2');
    Route::get('/3/penyampaian/{harmonisasi:judul}', 'destroy3');
    Route::get('/4/penyampaian/{harmonisasi:judul}', 'destroy4');
    Route::get('/5/penyampaian/{harmonisasi:judul}', 'destroy5');
});

// grafik
Route::get('/grafik', [dataController::class, 'index']);
Route::post('/grafikAdmin', [dataController::class, 'grafikAdmin']);
Route::post('/grafik', [dataController::class, 'grafik']);

// agenda
Route::controller(dataController::class)->group(function() {
    Route::get('/agenda', 'agenda');
    Route::post('/agenda', 'store');
    Route::get('/agenda/{agenda:nama}', 'hapus');
    Route::post('/agenda/{agenda:nama}', 'update');
    Route::get('/agenda/hapus/{agenda:nama}', 'destroy');
    Route::get('/aktif/{id}', 'aktif');
    Route::get('/nonaktif/{id}', 'nonaktif');
    Route::get('/uploadfoto', 'uploadfoto');
    Route::post('/uploadfoto/{id?}', 'uploadfoto_post')->name('upload-foto');
    Route::get('/remove_foto/{id}', 'remove_foto');
});

// Master Data
Route::controller(masterController::class)->middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('/role', 'role');
    Route::post('/role', 'role_store');
    Route::post('/role/{id}', 'role_update');
    // Route::get('/role/{id}', 'role_destroy');
    
    Route::get('/tahun', 'tahun');
    Route::post('/tahun', 'tahun_store');
    Route::get('/tahun/selected/{id}', 'tahun_selected');
    Route::post('/tahun/{id}', 'tahun_update');
    Route::get('/tahun/{id}', 'tahun_destroy');

    Route::get('/rancangan', 'rancangan');
    Route::post('/rancangan', 'rancangan_store');
    Route::post('/rancangan/{id}', 'rancangan_update');
    // Route::get('/role/{id}', 'role_destroy');

    Route::get('/kpengajuan', 'kpengajuan');
    Route::post('/kpengajuan', 'kpengajuan_store');
    Route::post('/kpengajuan/{id}', 'kpengajuan_update');
    Route::get('/kpengajuan/{id}', 'kpengajuan_destroy');

    Route::get('/pemrakarsa', 'pemrakarsa');
    Route::post('/pemrakarsa', 'pemrakarsa_store');
    Route::post('/pemrakarsa/{id}', 'pemrakarsa_update');
    Route::get('/pemrakarsa/{id}', 'pemrakarsa_destroy');

    Route::get('/posisi', 'posisi');
    Route::post('/posisi', 'posisi_store');
    Route::post('/posisi/{id}', 'posisi_update');
    // Route::get('/role/{id}', 'role_destroy');

    
    Route::get('/pdraf', 'pdraf');
    Route::post('/pdraf', 'pdraf_store');
    Route::post('/pdraf/{id}', 'pdraf_update');
    Route::get('/pdraf/{id}', 'pdraf_destroy');
});

// Users
Route::controller(userController::class)->group(function() {
    Route::get('/profile/{user:username}', 'index');
    Route::post('/profile/{user:username}', 'index_update');

    Route::get('/users', 'users')->middleware(['auth', 'isAdmin']);
    Route::get('/users/tambah', 'create')->middleware(['auth', 'isAdmin']);
    Route::post('/users/tambah', 'store')->middleware(['auth', 'isAdmin']);
    Route::get('/users/{user:username}', 'edit')->middleware(['auth', 'isAdmin']);
    Route::post('/users/{user:username}', 'update')->middleware(['auth', 'isAdmin']);
    Route::get('/user/{user:username}', 'destroy')->middleware(['auth', 'isAdmin']);
});

// perancang
Route::controller(perancangController::class)->middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('/pendiri', 'index');
    Route::post('/pendiri', 'store');
    Route::post('/pendiri/{perancang:id}', 'update');
    Route::get('/pendiri/{id}', 'destroy');
});