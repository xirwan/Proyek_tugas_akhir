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
use App\Http\Controllers\BaptistController;
use App\Http\Controllers\BaptistClassesController;
use App\Http\Controllers\BaptistClassDetailController;
use App\Http\Controllers\MemberBaptistController;
use App\Http\Controllers\AdminAttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Controllers\MemberScheduleController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/coba', function () {
    return view('coba');
});

Route::get('/portal', function () {
    return view('userdashboard');
})->name('portal')->middleware(['auth', 'verified', 'role:Jemaat']);

Route::prefix('master-data')->middleware('auth')->group(function () {

    Route::resource('schedule', ScheduleController::class);

    Route::resource('category', CategoryController::class)->middleware(['auth', 'verified']);
    
    Route::resource('type', TypeController::class)->middleware(['auth', 'verified']);
    
    Route::resource('position', PositionController::class)->middleware(['auth', 'verified']);

    Route::resource('branch', BranchController::class);

    Route::resource('role', RoleController::class);

    Route::resource('member', MemberController::class);

    Route::resource('news', NewsController::class);

    Route::resource('news-categories', NewsCategoryController::class);

    Route::get('certifications', [CertificationController::class, 'index'])->name('certifications.index');

    Route::get('certifications/{id}', [CertificationController::class, 'show'])->name('certifications.show');

    Route::post('certifications/{id}/verify', [CertificationController::class, 'verify'])->name('certifications.verify');

    Route::post('certifications/{id}/reject', [CertificationController::class, 'reject'])->name('certifications.reject');

    Route::post('certifications/create', [CertificationController::class, 'createForMember'])->name('certifications.createForMember');


});

Route::prefix('sunday-school')->middleware('auth')->group(function () {

    Route::resource('sunday-classes', SundaySchoolClassController::class);
    
    Route::get('sunday-classes/{classId}/students', [SundaySchoolClassController::class, 'viewClassStudents'])->name('sundayschoolclass.viewClassStudents');

    Route::get('sunday-classes/adjust-class/{childId}', [SundaySchoolClassController::class, 'showAdjustClassForm'])->name('sundayschoolclass.showAdjustClassForm');

    Route::post('sunday-classes/adjust-class/{childId}', [SundaySchoolClassController::class, 'adjustClass'])->name('sundayschoolclass.adjustClass');

    Route::get('attendance/class', [AttendanceController::class, 'classList'])->name('attendance.classList');

    Route::get('attendance/class/{class_id}', [AttendanceController::class, 'attendanceListByClass'])->name('attendance.classAttendance');

    Route::post('attendance/class/{class_id}/manual-checkin', [AttendanceController::class, 'manualCheckin'])->name('attendance.manualCheckin');

    Route::get('attendance/class/{class_id}/checkin-qr', [AttendanceController::class, 'showCheckinQr'])->name('attendance.showCheckinQr');

    Route::post('attendance/class/{class_id}/checkin', [AttendanceController::class, 'checkinByClass'])->name('attendance.checkinByClass');

    Route::get('attendance/history', [AdminAttendanceController::class, 'attendanceHistory'])->name('admin.attendance.history');

    Route::post('attendance/export', [AdminAttendanceController::class, 'exportToPdf'])->name('admin.attendance.export');

    Route::get('qr-code/children', [AttendanceController::class, 'listChildren'])->name('qr-code.children.list');

    Route::get('qr-code/children/generate-qr/{id}', [AttendanceController::class, 'generateQrForChild'])
    ->name('qr-code.children.generate.qr');

    Route::get('qr-code/generate-all-qr', [AttendanceController::class,'generateQrForAllChildrenWithoutQr']) ->name('qr-code.generate.all.qr');

    Route::prefix('reports')->group(function () {

        Route::get('/', [ReportController::class, 'index'])->name('admin.reports.index');

        Route::get('/create', [ReportController::class, 'create'])->name('admin.reports.create');

        Route::post('/store', [ReportController::class, 'store'])->name('admin.reports.store');

        Route::get('/download/{id}', [ReportController::class, 'download'])->name('admin.reports.download');

        Route::delete('/{id}', [ReportController::class, 'destroy'])->name('admin.reports.destroy');

    });
    
});

Route::get('/scheduling', [MemberScheduleController::class, 'index'])->name('scheduling.index');

Route::get('/scheduling/create', [MemberScheduleController::class, 'create'])->name('scheduling.create'); // Form tambah jadwal

Route::post('/scheduling/store', [MemberScheduleController::class, 'store'])->name('scheduling.store');

Route::get('/my-schedule', [MemberScheduleController::class, 'mySchedule'])->name('myschedule.index');


Route::middleware('auth')->group(function () {
    Route::get('/certifications/upload', [CertificationController::class, 'showUploadForm'])->name('certifications.uploadForm');
    Route::post('/certifications/upload', [CertificationController::class, 'uploadCertificate'])->name('certifications.upload');
});

Route::resource('baptist', BaptistController::class);

Route::resource('baptist-classes', BaptistClassesController::class);

// Route::resource('baptist-class-detail', BaptistClassDetailController::class)->only(['index']);

Route::get('/baptist-classes/{id}/members', [BaptistClassesController::class, 'viewClassMembers'])->name('baptist-classes.viewClassMembers');

Route::get('/baptist-classes/members/{id}/adjust', [BaptistClassesController::class, 'showAdjustClassForm'])->name('baptist-classes.showAdjustClassForm');

Route::post('/baptist-classes/members/{id}/adjust', [BaptistClassesController::class, 'adjustClass'])->name('baptist-classes.adjustClass');

Route::get('baptist-class-detail/{classDetail}/cancel-reschedule', [BaptistClassDetailController::class, 'cancelAndRescheduleForm'])->name('baptist-class-detail.cancelAndRescheduleForm');

Route::post('baptist-class-detail/{classDetail}/cancel-reschedule', [BaptistClassDetailController::class, 'cancelAndReschedule'])->name('baptist-class-detail.cancelAndReschedule');

Route::get('baptist-class-detail/index/{encryptedId}', [BaptistClassDetailController::class, 'index'])->name('baptist-class-detail.index');

Route::get('baptist-class-detail/create/{encryptedId}', [BaptistClassDetailController::class, 'create'])->name('baptist-class-detail.create');

Route::post('baptist-class-detail/store/{encryptedId}', [BaptistClassDetailController::class, 'store'])->name('baptist-class-detail.store');

// Route untuk menampilkan form absensi admin
Route::get('/baptist-class-detail/{classDetailId}/attendance', [BaptistClassDetailController::class, 'attendanceForm'])->name('baptist-class-detail.attendanceForm');

// Route untuk menyimpan absensi admin
Route::post('/baptist-class-detail/{classDetailId}/attendance', [BaptistClassDetailController::class, 'markAttendance'])->name('baptist-class-detail.markAttendance');



Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/member/register-child', [MemberController::class, 'createChildForm'])->name('member.createChildForm')->middleware(['auth', 'verified']);

Route::post('/member/store-child', [MemberController::class, 'storeChild'])->name('member.storeChild')->middleware(['auth', 'verified']);

Route::get('/member/children', [MemberController::class, 'showChildrenList'])->name('member.childrenList')->middleware(['auth', 'verified']);

// Menampilkan form pembuatan akun anak
Route::get('/member/{id}/create-child-account', [MemberController::class, 'createChildAccount'])->name('member.createChildAccount')->middleware(['auth', 'verified']);

// Menyimpan akun anak
Route::post('/member/{id}/store-child-account', [MemberController::class, 'storeChildAccount'])->name('member.storeChildAccount')->middleware(['auth', 'verified']);

Route::get('/member/children/{child}/edit', [MemberController::class, 'editChild'])->name('member.editChild');

Route::patch('/member/children/{child}', [MemberController::class, 'updateChild'])->name('member.updateChild');

Route::get('/attendance/parent-view', [AttendanceController::class, 'parentViewAttendance'])->name('attendance.parentView');

// Route::get('/qr-code/checkin/{id}', [AttendanceController::class, 'checkIn'])->name('qr-code.checkin');

// Route::post('/qr-code/checkin', [AttendanceController::class, 'processCheckIn'])->name('attendance.processCheckIn');


Route::get('/user/profile', [ProfileController::class, 'useredit'])->name('userprofile.edit');

Route::patch('/user/profile', [ProfileController::class, 'userupdate'])->name('userprofile.update');


// Route::get('register-baptist', [MemberBaptistController::class, 'index'])->name('member-baptist.index');

// Route::get('register-baptist/classes/{encryptedId}', [MemberBaptistController::class, 'getBaptistClasses'])->name('member-baptist.classes');

Route::get('/member-baptist', [MemberBaptistController::class, 'index'])->name('memberbaptist.index');

// Route::get('/member-baptist/classes/{encryptedId}', [MemberBaptistController::class, 'getBaptistClasses'])->name('memberbaptist.classes');

Route::post('/member-baptist/register', [MemberBaptistController::class, 'register'])->name('memberbaptist.register');

Route::get('/member-baptist/class-details', [MemberBaptistController::class, 'showDetails'])->name('memberbaptist.details');




Route::get('/get-valid-weeks/{classId}', [ReportController::class, 'getValidWeeks']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:SuperAdmin|Admin'])->name('dashboard');

// Route::group(['middleware' => ['auth', 'verified', 'role:SuperAdmin']], function () {
//     Route::resource('branch', BranchController::class);
//     Route::resource('role', RoleController::class);
//     Route::resource('member', MemberController::class);
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/pembaptisan', function () {
        return view('pembaptisan');
    })->name('pembaptisan');
}); 

require __DIR__.'/auth.php';
