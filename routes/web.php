<?php

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

    // Employer registration form
    Route::get('/employers/register', [EmployerController::class, 'create'])->name('employers.create');
    Route::post('/employers/register', [EmployerController::class, 'store'])->name('employers.store');

    // Admin approval dashboard
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/employers', [EmployerController::class, 'index'])->name('admin.employers.index');
        Route::post('/admin/employers/{employer}/approve', [EmployerController::class, 'approve'])->name('admin.employers.approve');
        Route::post('/admin/employers/{employer}/reject', [EmployerController::class, 'reject'])->name('admin.employers.reject');
    });
});

require __DIR__ . '/auth.php';
