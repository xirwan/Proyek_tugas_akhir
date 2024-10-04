<?php

use Illuminate\Support\Facades\Route;
use illuminate\Auth\Middleware\Authorize;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\TypeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/coba', function () {
    return view('coba');
});

Route::resource('/schedule', ScheduleController::class)->middleware(['auth', 'verified']);

Route::resource('/category', CategoryController::class)->middleware(['auth', 'verified']);

Route::resource('/type', TypeController::class)->middleware(['auth', 'verified']);

Route::resource('/position', PositionController::class)->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:SuperAdmin'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified', 'role:SuperAdmin']], function () {
    Route::resource('/branch', BranchController::class);
    Route::resource('/role', RoleController::class);
    Route::resource('/member', MemberController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/pembaptisan', function () {
        return view('pembaptisan');
    })->name('pembaptisan');
}); 


require __DIR__.'/auth.php';
