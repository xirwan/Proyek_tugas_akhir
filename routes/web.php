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
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\SundaySchoolClassController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/coba', function () {
    return view('coba');
});

Route::get('/portal', function () {
    return view('userdashboard');
})->name('portal')->middleware(['auth', 'verified', 'role:Jemaat']);

Route::resource('schedule', ScheduleController::class)->middleware(['auth', 'verified']);

Route::resource('category', CategoryController::class)->middleware(['auth', 'verified']);

Route::resource('type', TypeController::class)->middleware(['auth', 'verified']);

Route::resource('position', PositionController::class)->middleware(['auth', 'verified']);

Route::resource('sunday-classes', SundaySchoolClassController::class)->middleware(['auth', 'verified']);

Route::get('/sunday-classes/{classId}/students', [SundaySchoolClassController::class, 'viewClassStudents'])->name('sundayschoolclass.viewClassStudents')->middleware(['auth', 'verified']);

Route::get('/sunday-classes/adjust-class/{childId}', [SundaySchoolClassController::class, 'showAdjustClassForm'])->name('sundayschoolclass.showAdjustClassForm')->middleware(['auth', 'verified']);

Route::post('/sunday-classes/adjust-class/{childId}', [SundaySchoolClassController::class, 'adjustClass'])->name('sundayschoolclass.adjustClass')->middleware(['auth', 'verified']);

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/member/register-child', [MemberController::class, 'createChildForm'])->name('member.createChildForm')->middleware(['auth', 'verified']);

Route::post('/member/store-child', [MemberController::class, 'storeChild'])->name('member.storeChild')->middleware(['auth', 'verified']);

Route::get('/member/children', [MemberController::class, 'showChildrenList'])->name('member.childrenList')->middleware(['auth', 'verified']);

// Menampilkan form pembuatan akun anak
Route::get('/member/{id}/create-child-account', [MemberController::class, 'createChildAccount'])->name('member.createChildAccount')->middleware(['auth', 'verified']);

// Menyimpan akun anak
Route::post('/member/{id}/store-child-account', [MemberController::class, 'storeChildAccount'])->name('member.storeChildAccount')->middleware(['auth', 'verified']);

Route::get('/qr-code/children', [AttendanceController::class, 'listChildren'])->name('qr-code.children.list');

Route::get('/qr-code/children/generate-qr/{id}', [AttendanceController::class, 'generateQrForChild'])
->name('qr-code.children.generate.qr');

Route::get('/qr-code/generate-all-qr', [AttendanceController::class,'generateQrForAllChildrenWithoutQr']) ->name('qr-code.generate.all.qr');

// Route::get('/qr-code/checkin/{id}', [AttendanceController::class, 'checkIn'])->name('qr-code.checkin');

// Route::post('/qr-code/checkin', [AttendanceController::class, 'processCheckIn'])->name('attendance.processCheckIn');

Route::get('/attendance/class', [AttendanceController::class, 'classList'])->name('attendance.classList');

Route::get('/attendance/class/{class_id}', [AttendanceController::class, 'attendanceListByClass'])->name('attendance.classAttendance');

Route::post('/attendance/class/{class_id}/manual-checkin', [AttendanceController::class, 'manualCheckin'])->name('attendance.manualCheckin');

Route::get('/attendance/class/{class_id}/checkin-qr', [AttendanceController::class, 'showCheckinQr'])->name('attendance.showCheckinQr');

Route::post('/attendance/class/{class_id}/checkin', [AttendanceController::class, 'checkinByClass'])->name('attendance.checkinByClass');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:SuperAdmin'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified', 'role:SuperAdmin']], function () {
    Route::resource('branch', BranchController::class);
    Route::resource('role', RoleController::class);
    Route::resource('member', MemberController::class);
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
