<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BodyController;
use App\Http\Controllers\ChamberController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/', fn() => redirect()->route('dashboard'));

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Bodies — Admin + Attendant can create/edit, Management read-only via policies in views
    Route::resource('bodies', BodyController::class);
    Route::post('/bodies/{body}/kins', [BodyController::class, 'storeKin'])->name('bodies.kins.store');
    Route::delete('/bodies/{body}/kins/{kin}', [BodyController::class, 'destroyKin'])->name('bodies.kins.destroy');

    // Chambers — view by all, manage restricted in controller/views
    Route::resource('chambers', ChamberController::class);

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clock-out');

    // Releases
    Route::get('/releases', [ReleaseController::class, 'index'])->name('releases.index');
    Route::get('/releases/create', [ReleaseController::class, 'create'])->name('releases.create');
    Route::post('/releases', [ReleaseController::class, 'store'])->name('releases.store');
    Route::get('/releases/bodies/{body}/kins', [ReleaseController::class, 'getKins'])->name('releases.kins');
    Route::get('/releases/{release}/certificate', [ReleaseController::class, 'certificate'])->name('releases.certificate');
    Route::get('/releases/{release}/certificate/pdf', [ReleaseController::class, 'certificatePdf'])->name('releases.certificate.pdf');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/admissions', [ReportController::class, 'admissions'])->name('reports.admissions');
    Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
    Route::get('/reports/chambers', [ReportController::class, 'chambers'])->name('reports.chambers');
    Route::get('/reports/releases', [ReportController::class, 'releases'])->name('reports.releases');

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.index');
    });
});
