<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\TpsController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\PemilihController;
use App\Http\Controllers\DptController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LeaderController;  
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

Route::get('/', function () {
    return view('index');
})->middleware('auth');

//kecamatan
Route::get('/tambah-kecamatan', [KecamatanController::class, 'create'])->middleware('auth');
Route::get('/edit-kecamatan/{kecamatan}', [KecamatanController::class, 'edit'])->middleware('auth');
Route::prefix('/kecamatan')->name('.kecamatan')->middleware('auth')->group(function () {
    Route::get('/', [KecamatanController::class, 'index']);
    Route::post('/create', [KecamatanController::class, 'store']);
    Route::put('/edit/{kecamatan}', [KecamatanController::class, 'update']);
    Route::get('/delete/{kecamatan}', [KecamatanController::class, 'destroy']);
});

// desa
Route::get('/tambah-desa', [DesaController::class, 'create'])->middleware('auth');
Route::get('/edit-desa/{desa}', [DesaController::class, 'edit'])->middleware('auth');
Route::prefix('/desa')->name('.desa')->middleware('auth')->group(function () {
    Route::get('/', [DesaController::class, 'index']);
    Route::post('/create', [DesaController::class, 'store']);
    Route::put('/edit/{desa}', [DesaController::class, 'update']);
    Route::get('/delete/{desa}', [DesaController::class, 'destroy']);
});

// pemilih
Route::get('/tambah-pemilih', [PemilihController::class, 'create'])->middleware('auth');
Route::get('/edit-pemilih/{pemilih}', [PemilihController::class, 'edit'])->middleware('auth');
Route::prefix('/pemilih')->name('.pemilih')->middleware('auth')->group(function () {
    Route::get('/', [PemilihController::class, 'index']);
    Route::post('/create', [PemilihController::class, 'store']);
    Route::put('/edit/{pemilih}', [PemilihController::class, 'update']);
    Route::get('/delete/{pemilih}', [PemilihController::class, 'destroy']);
    Route::get('/export', [PemilihController::class, 'export']);
});

//tps
Route::get('/tambah-tps', [TpsController::class, 'create'])->middleware('auth');
Route::get('/edit-tps/{tps}', [TpsController::class, 'edit'])->middleware('auth');
Route::prefix('/tps')->name('.tps')->middleware('auth')->group(function () {
    Route::get('/', [TpsController::class, 'index']);
    Route::post('/create', [TpsController::class, 'store']);
    Route::put('/edit/{tps}', [TpsController::class, 'update']);
    Route::get('/delete/{tps}', [TpsController::class, 'destroy']);
});

// pemilih
Route::get('/tambah-dpt', [DptController::class, 'create'])->middleware('auth');
Route::get('/edit-dpt/{pemilih}', [DptController::class, 'edit'])->middleware('auth');
Route::prefix('/dpt')->name('.dpt')->middleware('auth')->group(function () {
    Route::get('/', [DptController::class, 'index']);
    Route::post('/create', [DptController::class, 'store']);
    Route::put('/edit/{pemilih}', [DptController::class, 'update']);
    Route::get('/delete/{pemilih}', [DptController::class, 'destroy']);
});

//leader
Route::get('/tambah-leader', [LeaderController::class, 'create'])->middleware('auth');
Route::get('/edit-leader/{leader}', [LeaderController::class, 'edit'])->middleware('auth');
Route::prefix('/leader')->name('.leader')->middleware('auth')->group(function () {
    Route::get('/', [LeaderController::class, 'index']);
    Route::post('/create', [LeaderController::class, 'store']);
    Route::put('/edit/{leader}', [LeaderController::class, 'update']);
    Route::get('/delete/{leader}', [LeaderController::class, 'destroy']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//user
Route::get('/tambah-user', [UserController::class, 'create'])->middleware('auth');
Route::get('/edit-user/{user}', [UserController::class, 'edit'])->middleware('auth');
Route::prefix('/user')->name('.user')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/create', [UserController::class, 'store']);
    Route::put('/edit/{user}', [UserController::class, 'update']);
    Route::get('/delete/{user}', [UserController::class, 'destroy']);
});

//role and permission
Route::get('/tambah-role', [RoleController::class, 'create'])->middleware('auth');
Route::get('/edit-role/{role}', [RoleController::class, 'edit'])->middleware('auth');
Route::prefix('/role')->name('.role')->middleware('auth')->group(function () {
    Route::get('/', [RoleController::class, 'index']);
    Route::post('/create', [RoleController::class, 'store']);
    Route::put('/edit/{role}', [RoleController::class, 'update']);
    Route::get('/delete/{role}', [RoleController::class, 'destroy']);
});

require __DIR__.'/auth.php';
