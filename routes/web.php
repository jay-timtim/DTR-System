<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DtrController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;
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

    Route::get('/admin', [DashboardController::class, 'dashboard']);

    // Employee Management
    Route::resource('employees', EmployeeController::class);

    // Optional alias for your current page URL
    Route::get('/manage-employees', [EmployeeController::class, 'index']);

    // DTR Records
    Route::get('/view-dtr',[DtrController::class,'viewDtr']);

    // Reports
    Route::get('/reports',[ReportController::class,'reports']);

    // Logout
    Route::get('/logout', function () {
        session()->forget(['admin_id','admin_username']);
        return redirect('/');
    });

});


