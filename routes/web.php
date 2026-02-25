<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisputeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeSearchController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\EmploymentHistoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/2fa/verify', [TwoFactorController::class, 'showVerifyForm'])->name('2fa.verify');
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify.post');

    Route::get('/profile/2fa', [TwoFactorController::class, 'showSetupForm'])->name('2fa.setup');
    Route::post('/profile/2fa', [TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::post('/profile/2fa/disable', [TwoFactorController::class, 'disable'])->name('2fa.disable');
});

Route::get('/register/choose', [AuthController::class, 'choose'])->name('register.choose');
Route::post('/register/employee/store', [AuthController::class, 'storeEmployeeSingle'])->name('register.employee.store');
Route::post('/register/combined/store', [AuthController::class, 'storeCombined'])->name('register.combined.store');

Route::middleware(['auth'])->group(function () {

    Route::get('/employee/search', [EmployeeSearchController::class, 'index'])
        ->name('employee.search');

    Route::post('/employee/search', [EmployeeSearchController::class, 'search'])
        ->name('employee.search.submit');

    Route::resource('employees', EmployeeController::class);
    Route::post('/employee/store', [EmployeeController::class, 'storeEmployee'])
        ->name('employees.storeEmployee');

    Route::resource('employers', EmployerController::class);
    Route::post('/employer/store', [EmployerController::class, 'storeEmployer'])
        ->name('employers.storeEmployer');
    Route::get(
        '/employees/{employee}/history',
        [EmploymentHistoryController::class, 'index']
    )
        ->name('employees.history');

    Route::post(
        '/employment-histories',
        [EmploymentHistoryController::class, 'store']
    )
        ->name('employment-histories.store');
    Route::resource('employment-histories', EmploymentHistoryController::class);
    // Employer registration form
    Route::get('/employers/register', [EmployerController::class, 'create'])->name('employers.create');
    Route::post('/employers/register', [EmployerController::class, 'store'])->name('employers.store');

    // Admin approval dashboard
    Route::get('/admin/employers', [EmployerController::class, 'index'])->name('admin.employers.index');
    Route::post('/admin/employers/{employer}/approve', [EmployerController::class, 'approve'])->name('admin.employers.approve');
    Route::post('/admin/employers/{employer}/reject', [EmployerController::class, 'reject'])->name('admin.employers.reject');

    // Employee raises dispute
    Route::post('/employment-histories/{history}/dispute', [DisputeController::class, 'store'])
        ->name('disputes.store');

    // Admin views disputes
    Route::get('/admin/disputes', [DisputeController::class, 'index'])->name('admin.disputes.index');
    Route::post('/admin/disputes/{dispute}/resolve', [DisputeController::class, 'resolve'])->name('admin.disputes.resolve');
    Route::post('/admin/disputes/{dispute}/reject', [DisputeController::class, 'reject'])->name('admin.disputes.reject');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/my-history', [EmployeeController::class, 'myHistory'])
        ->name('employee.history');

    Route::get('/my-disputes', [DisputeController::class, 'myDisputes'])
        ->name('employee.disputes.index');

    Route::post('/my-disputes', [DisputeController::class, 'store'])
        ->name('employee.disputes.store');

    // Employer Profile

    // Employee Search / Verification
    Route::get('/employee/search', [EmployeeSearchController::class, 'index'])
        ->name('employee.search');

    Route::post('/employee/search', [EmployeeSearchController::class, 'search'])
        ->name('employee.search.submit');

    // Employment History Management
    Route::get('/history', [EmploymentHistoryController::class, 'index'])->name('employer.history.index');
    Route::get('/history/create', [EmploymentHistoryController::class, 'create'])->name('employer.history.create');
    Route::post('/history/store', [EmploymentHistoryController::class, 'store'])->name('employer.history.store');
    Route::get('/history/{history}/edit', [EmploymentHistoryController::class, 'edit'])->name('employer.history.edit');
    Route::put('/history/{history}', [EmploymentHistoryController::class, 'update'])->name('employer.history.update');
    Route::delete('/history/{history}', [EmploymentHistoryController::class, 'destroy'])->name('employer.history.destroy');

    // Disputes Management
    Route::get('/disputes', [DisputeController::class, 'index'])->name('employer.disputes.index');
    Route::get('/disputes/create', [DisputeController::class, 'create'])->name('employer.disputes.create');
    Route::post('/disputes/store', [DisputeController::class, 'store'])->name('employer.disputes.store');
    Route::get('/disputes/{dispute}/show', [DisputeController::class, 'show'])->name('employer.disputes.show');
    Route::put('/disputes/{dispute}/resolve', [DisputeController::class, 'resolve'])->name('employer.disputes.resolve');

    Route::get('/analytics', [AnalyticsController::class, 'index'])
        ->name('analytics.index');

    Route::get('/reports/pdf', [ReportController::class, 'laborSummaryPDF'])->name('reports.pdf');

    Route::get('/reports/excel',[ReportController::class, 'employmentHistoryExcel'])->name('reports.excel');

    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.logs.index');
});

require __DIR__ . '/auth.php';
