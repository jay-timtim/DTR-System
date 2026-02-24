<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dtr');
});

Route::get('admin', function () {
    return view('dashboard');
});
Route::get('manage-employees', function () {
    return view('manage-employees');
});
Route::get('view-dtr', function () {
    return view('view-dtr');
});
Route::get('reports', function () {
    return view('reports');
});
