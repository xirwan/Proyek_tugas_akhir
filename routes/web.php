<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AnggotaController;
use illuminate\Auth\Middleware\Authorize;
use App\Http\Controllers\PositionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/coba', function () {
    return view('coba');
});

Route::get('/anggota', function () {
    return view('anggota');
})->middleware(['auth', 'verified']);

Route::resource('/jadwal', JadwalController::class)->middleware(['auth', 'verified']);

Route::resource('/posisi', PositionController::class)->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified', 'role:SuperAdmin']], function () {
    Route::resource('/cabang', CabangController::class);
    Route::resource('/role', RoleController::class);
    Route::resource('/anggota', AnggotaController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
