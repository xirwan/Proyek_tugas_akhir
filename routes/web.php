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
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SeminarController;
use App\Http\Middleware\CheckMemberStatus;
use App\Http\Controllers\LandingController;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/', [LandingController::class, 'landing'])->name('landing');

Route::get('/landing-activities', [LandingController::class, 'index'])->name('landing-activities.index');

Route::get('/coba', function () {
    return view('coba');
});
Route::middleware('auth')->group(function () {
    Route::middleware('role:SuperAdmin')->group(function () {
        Route::prefix('master-data')->group(function () {
            Route::resource('schedule', ScheduleController::class);
            Route::post('/schedule/{id}/activate', [ScheduleController::class, 'activate'])->name('schedule.activate');
            Route::resource('category', CategoryController::class);
            Route::post('/category/{id}/activate', [CategoryController::class, 'activate'])->name('category.activate');
            Route::resource('type', TypeController::class);
            Route::post('/type/{id}/activate', [TypeController::class, 'activate'])->name('type.activate');
            Route::resource('position', PositionController::class);
            Route::post('/position/{id}/activate', [PositionController::class, 'activate'])->name('position.activate');
            Route::resource('branch', BranchController::class);
            Route::post('/branch/{id}/activate', [BranchController::class, 'activate'])->name('branch.activate');
            Route::resource('role', RoleController::class);
            Route::resource('member', MemberController::class);
            Route::post('/member/{id}/active', [MemberController::class, 'active'])->name('member.active');
            Route::resource('news', NewsController::class);
            Route::resource('news-categories', NewsCategoryController::class);
            // joel
            Route::get('certifications', [CertificationController::class, 'index'])->name('certifications.index');
            Route::get('certifications/{id}', [CertificationController::class, 'show'])->name('certifications.show');
            Route::post('certifications/{id}/verify', [CertificationController::class, 'verify'])->name('certifications.verify');
            Route::post('certifications/{id}/reject', [CertificationController::class, 'reject'])->name('certifications.reject');
            Route::post('certifications/create', [CertificationController::class, 'createForMember'])->name('certifications.createForMember');
        });
        Route::prefix('scheduling')->group(function () {
            Route::get('/', [MemberScheduleController::class, 'index'])->name('scheduling.index');
            Route::get('/create', [MemberScheduleController::class, 'create'])->name('scheduling.create');
            Route::post('/store', [MemberScheduleController::class, 'store'])->name('scheduling.store');
            Route::get('/available-options', [MemberScheduleController::class, 'availableOptions'])->name('scheduling.availableOptions');
            Route::get('/{id}/edit', [MemberScheduleController::class, 'edit'])->name('scheduling.edit');
            Route::put('/{id}', [MemberScheduleController::class, 'update'])->name('scheduling.update');
        });
    });
    Route::middleware('role:SuperAdmin|Admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::prefix('sunday-school')->group(function () {
            Route::resource('sunday-classes', SundaySchoolClassController::class);
            Route::post('/sunday-classes/{id}/active', [SundaySchoolClassController::class, 'active'])->name('sunday-classes.active');
            Route::get('/sunday-classes/{classId}/students', [SundaySchoolClassController::class, 'viewClassStudents'])->name('sundayschoolclass.viewClassStudents');
            Route::get('/sunday-classes/adjust-class/{childId}', [SundaySchoolClassController::class, 'showAdjustClassForm'])->name('sundayschoolclass.showAdjustClassForm');
            Route::post('/sunday-classes/adjust-class/{childId}', [SundaySchoolClassController::class, 'adjustClass'])->name('sundayschoolclass.adjustClass');
            Route::get('/attendance/class', [AttendanceController::class, 'classList'])->name('attendance.classList');
            Route::get('/attendance/class-admin', [AttendanceController::class, 'classListAdmin'])->name('attendance.classListAdmin');
            Route::get('/attendance/class/{class_id}', [AttendanceController::class, 'attendanceListByClass'])->name('attendance.classAttendance');
            Route::post('/attendance/class/{class_id}/manual-checkin', [AttendanceController::class, 'manualCheckin'])->name('attendance.manualCheckin');
            Route::get('/attendance/class/{class_id}/checkin-qr', [AttendanceController::class, 'showCheckinQr'])->name('attendance.showCheckinQr');
            Route::post('/attendance/class/{class_id}/checkin', [AttendanceController::class, 'checkinByClass'])->name('attendance.checkinByClass');
            Route::get('/attendance/history', [AdminAttendanceController::class, 'attendanceHistory'])->name('admin.attendance.history');
            Route::post('/attendance/export', [AdminAttendanceController::class, 'exportToPdf'])->name('admin.attendance.export');
            Route::get('/qr-code/children', [AttendanceController::class, 'listChildren'])->name('qr-code.children.list');
            Route::get('/qr-code/children/generate-qr/{id}', [AttendanceController::class, 'generateQrForChild'])->name('qr-code.children.generate.qr');
            Route::get('/qr-code/generate-all-qr', [AttendanceController::class,'generateQrForAllChildrenWithoutQr']) ->name('qr-code.generate.all.qr');
            Route::prefix('reports')->group(function () {
                Route::get('/', [ReportController::class, 'index'])->name('admin.reports.index');
                Route::get('/create', [ReportController::class, 'create'])->name('admin.reports.create');
                Route::get('/get-valid-weeks/{classId}', [ReportController::class, 'getValidWeeks']);
                Route::post('/store', [ReportController::class, 'store'])->name('admin.reports.store');
                Route::get('/show/{id}', [ReportController::class, 'show'])->name('admin.reports.show');
                Route::get('/download/{id}', [ReportController::class, 'download'])->name('admin.reports.download');
                Route::put('/update/{id}', [ReportController::class, 'update'])->name('admin.reports.update');
                Route::delete('/{id}', [ReportController::class, 'destroy'])->name('admin.reports.destroy');
            });
        });
        Route::prefix('activities')->group(function(){
            Route::get('/', [ActivityController::class, 'index'])->name('activities.index');
            Route::get('/create', [ActivityController::class, 'create'])->name('activities.create');
            Route::post('/store', [ActivityController::class, 'storeActivity'])->name('activities.store');
            Route::get('/{id}', [ActivityController::class, 'show'])->name('activities.show');
            Route::get('/{id}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
            Route::put('/{id}', [ActivityController::class, 'update'])->name('activities.update');
            Route::post('/{id}/approve', [ActivityController::class, 'approveActivity'])->name('activities.approve');
            Route::post('/{id}/reject', [ActivityController::class, 'rejectActivity'])->name('activities.reject');
            Route::get('/{id}/participants', [ActivityController::class, 'viewParticipants'])->name('activities.participants.view');
            Route::post('/{id}/verify-payment', [ActivityController::class, 'verifyPayment'])->name('activities.payment.verify');
            Route::post('/{id}/reject-payment', [ActivityController::class, 'rejectPayment'])->name('activities.payment.reject');
        });
        Route::get('/activity-list', [ActivityController::class, 'indexAdmin'])->name('listactivities.index');
    });
    Route::get('/my-schedule', [MemberScheduleController::class, 'mySchedule'])->middleware(['auth', 'role:Admin'])->name('myschedule.index');
    Route::middleware('role:Jemaat')->group(function () {
        Route::get('/portal', function () {
            return view('userdashboard');
        })->name('portal')->middleware(CheckMemberStatus::class);
        Route::prefix('member')->group(function (){
            Route::get('/register-child', [MemberController::class, 'createChildForm'])->name('member.createChildForm')->middleware(['auth', 'verified']);
            Route::post('/store-child', [MemberController::class, 'storeChild'])->name('member.storeChild')->middleware(['auth', 'verified']);
            Route::get('/children', [MemberController::class, 'showChildrenList'])->name('member.childrenList')->middleware(['auth', 'verified']);
            Route::get('/{id}/create-child-account', [MemberController::class, 'createChildAccount'])->name('member.createChildAccount')->middleware(['auth', 'verified']);
            Route::post('/{id}/store-child-account', [MemberController::class, 'storeChildAccount'])->name('member.storeChildAccount')->middleware(['auth', 'verified']);
            Route::get('/children/{child}/edit', [MemberController::class, 'editChild'])->name('member.editChild');
            Route::patch('/children/{child}', [MemberController::class, 'updateChild'])->name('member.updateChild');
        });
        Route::prefix('childrens-activities')->group(function(){
            Route::get('/', [ActivityController::class, 'indexParent'])->name('activities.parent.index');
            Route::get('/{id}/register', [ActivityController::class, 'registerForm'])->name('activities.register.form');
            Route::post('/{id}/register', [ActivityController::class, 'register'])->name('activities.register.children');
            Route::get('/{id}', [ActivityController::class, 'showParent'])->name('activities.parent.show');
            Route::post('/{id}/upload-payment', [ActivityController::class, 'uploadPayment'])->name('activities.upload.payment');
        });
        Route::get('/user/profile', [ProfileController::class, 'useredit'])->name('userprofile.edit');
        Route::patch('/user/profile', [ProfileController::class, 'userupdate'])->name('userprofile.update');
        Route::get('/attendance/parent-view', [AttendanceController::class, 'parentViewAttendance'])->name('attendance.parentView');
    });
});

//joel
Route::resource('baptist', BaptistController::class);

Route::resource('baptist-classes', BaptistClassesController::class);

Route::get('/baptist-classes/{id}/members', [BaptistClassesController::class, 'viewClassMembers'])->name('baptist-classes.viewClassMembers');

Route::get('/baptist-classes/members/{id}/adjust', [BaptistClassesController::class, 'showAdjustClassForm'])->name('baptist-classes.showAdjustClassForm');

Route::post('/baptist-classes/members/{id}/adjust', [BaptistClassesController::class, 'adjustClass'])->name('baptist-classes.adjustClass');

Route::get('/baptist-class-detail/{classDetail}/cancel-reschedule', [BaptistClassDetailController::class, 'cancelAndRescheduleForm'])->name('baptist-class-detail.cancelAndRescheduleForm');

Route::post('/baptist-class-detail/{classDetail}/cancel-reschedule', [BaptistClassDetailController::class, 'cancelAndReschedule'])->name('baptist-class-detail.cancelAndReschedule');

Route::get('/baptist-class-detail/index/{encryptedId}', [BaptistClassDetailController::class, 'index'])->name('baptist-class-detail.index');

Route::get('/baptist-class-detail/create/{encryptedId}', [BaptistClassDetailController::class, 'create'])->name('baptist-class-detail.create');

Route::post('/baptist-class-detail/store/{encryptedId}', [BaptistClassDetailController::class, 'store'])->name('baptist-class-detail.store');

Route::get('/baptist-class-detail/{classDetailId}/attendance', [BaptistClassDetailController::class, 'attendanceForm'])->name('baptist-class-detail.attendanceForm');

Route::post('/baptist-class-detail/{classDetailId}/attendance', [BaptistClassDetailController::class, 'markAttendance'])->name('baptist-class-detail.markAttendance');

Route::get('/seminars', [SeminarController::class, 'index'])->name('seminars.index');

Route::get('/attendance-seminars', [SeminarController::class, 'indexAttendance'])->name('seminars.indexAttendance');

Route::get('/attendance-seminars/{id}/memberslist', [SeminarController::class, 'showAttendance'])->name('seminars.attendancelist');

Route::post('/attendance-seminars/{id}/memberslist', [SeminarController::class, 'attendanceSeminars'])->name('seminars.attendanceSave');

Route::get('/seminars/create', [SeminarController::class, 'create'])->name('seminars.create');

Route::get('/seminars/show/{id}', [SeminarController::class, 'show'])->name('seminars.show');

Route::post('/seminars/store', [SeminarController::class, 'store'])->name('seminars.store');

Route::put('/seminars/{id}', [SeminarController::class, 'update'])->name('seminars.update');

Route::get('/member-seminars', [SeminarController::class, 'indexMember'])->name('seminars.indexmember');

Route::post('/member-seminars/register/{id}', [SeminarController::class, 'register'])->name('seminars.registermember');

Route::middleware('auth')->group(function () {
    Route::get('/certifications/upload', [CertificationController::class, 'showUploadForm'])->name('certifications.uploadForm');
    Route::post('/certifications/upload', [CertificationController::class, 'uploadCertificate'])->name('certifications.upload');
});

// Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

// Route::post('/register', [RegisteredUserController::class, 'store']);

// Route::get('/qr-code/checkin/{id}', [AttendanceController::class, 'checkIn'])->name('qr-code.checkin');

// Route::post('/qr-code/checkin', [AttendanceController::class, 'processCheckIn'])->name('attendance.processCheckIn');

// Route::get('register-baptist', [MemberBaptistController::class, 'index'])->name('member-baptist.index');

// Route::get('register-baptist/classes/{encryptedId}', [MemberBaptistController::class, 'getBaptistClasses'])->name('member-baptist.classes');

// Route::get('/member-baptist/classes/{encryptedId}', [MemberBaptistController::class, 'getBaptistClasses'])->name('memberbaptist.classes');

Route::get('/member-baptist', [MemberBaptistController::class, 'index'])->name('memberbaptist.index');

Route::post('/member-baptist/register', [MemberBaptistController::class, 'register'])->name('memberbaptist.register');

Route::get('/member-baptist/class-details', [MemberBaptistController::class, 'showDetails'])->name('memberbaptist.details');

require __DIR__.'/auth.php';
