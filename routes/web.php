<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPasswordController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\DtrController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalaryCalculatorController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dtr');
});
Route::post('/dtr/log', [AttendanceController::class, 'log']);
Route::get('/dtr/status/{employeeId}', [AttendanceController::class, 'getStatus']);

// admin login
Route::get('/admin/login', [AdminController::class, 'showLogin']);
Route::post('/admin/login', [AdminController::class, 'login']);


// protected admin routes
Route::middleware('admin.auth')->group(function () {

    // Deduction Panel Routes
    Route::get('/admin/deductions', [DeductionController::class, 'index'])->name('admin.deductions.index');
    Route::post('/admin/deductions/update', [DeductionController::class, 'update'])->name('admin.deductions.update');

    // Salary Calculator Routes
    Route::get('/admin/salary-calculator', [SalaryCalculatorController::class, 'index'])->name('admin.salary.index');
});


    Route::get('/admin/change-password', [AdminPasswordController::class, 'index'])->name('admin.password.index');
    Route::post('/admin/change-password/update', [AdminPasswordController::class, 'update'])->name('admin.password.update');

    Route::get('/admin/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/admin/settings/update', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/admin', [DashboardController::class, 'dashboard']);

    // Employee Management
    Route::resource('employees', EmployeeController::class);

    // Optional alias for your current page URL
    Route::get('/manage-employees', [EmployeeController::class, 'index']);

    // DTR Records
    Route::get('/view-dtr',[DtrController::class,'viewDTR']);

    // Reports
    Route::get('/reports',[ReportController::class,'reports']);

    // Logout
    Route::get('/logout', function () {
        session()->forget(['admin_id','admin_username']);
        return redirect('/');
    });




