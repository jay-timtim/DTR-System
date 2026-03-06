<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dtr');
});

// admin login
Route::get('/admin/login', [AdminController::class, 'showLogin']);
Route::post('/admin/login', [AdminController::class, 'login']);


// protected admin routes
Route::middleware('admin.auth')->group(function () {

    Route::get('/admin', function () {
        return view('dashboard');
    });

    Route::get('/manage-employees', function () {
        return view('manage-employees');
    });

    Route::get('/view-dtr', function () {
        return view('view-dtr');
    });

    Route::get('/reports', function () {
        return view('reports');
    });

    Route::get('/logout', function () {
        session()->forget(['admin_id','admin_username']);
        return redirect('/');
    });

});
