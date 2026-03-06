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


// admin login
Route::get('/admin/login', [AdminController::class, 'showLogin']);
Route::post('/admin/login', [AdminController::class, 'login']);


// protected admin routes
Route::middleware('admin.auth')->group(function () {

    Route::get('/admin', [DashboardController::class, 'dashboard']);

    Route::get('manage-employees', [EmployeeController::class, 'index']);

    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');

    Route::get('/view-dtr',[DtrController::class,'viewDtr']);

    Route::get('/reports',[ReportController::class,'reports']);

    Route::get('/logout', function () {
        session()->forget(['admin_id','admin_username']);
        return redirect('/');
    });

});
