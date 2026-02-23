<?php

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
});

Route::middleware(['auth'])->group(function () {

    Route::get('/employee/search', [EmployeeSearchController::class, 'index'])
        ->name('employee.search');

    Route::post('/employee/search', [EmployeeSearchController::class, 'search'])
        ->name('employee.search.submit');

    Route::resource('employees', EmployeeController::class);
    Route::resource('employers', EmployerController::class);
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
});

require __DIR__ . '/auth.php';
