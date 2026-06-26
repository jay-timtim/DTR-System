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

// Recent Logs
Route::get('/dtr/recent-logs', function() {
    $today = now()->toDateString();

    $logs = DB::table('attendance_logs')
        ->join('employees', 'attendance_logs.employee_id', '=', 'employees.employee_id')
        ->select(
            'attendance_logs.log_time',
            'attendance_logs.log_type',
            'employees.first_name',
            'employees.last_name'
        )
        ->whereDate('attendance_logs.log_date', $today)
        ->latest('attendance_logs.log_time')
        ->limit(5) // Keep the toast small and clean
        ->get();

    return response()->json($logs);
});


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
    Route::get('/admin/id-generator', [EmployeeController::class, 'showIdGenerator'])->name('employees.id-generator');

    // Optional alias for your current page URL
    Route::get('/manage-employees', [EmployeeController::class, 'index']);

    // DTR Records
    Route::get('/view-dtr',[DtrController::class,'viewDTR']);
    use Illuminate\Http\Request;



Route::post('/admin/dtr/update', function(Request $request) {
    // 1. Extract context parameters passed from the edit modal form
    $employeeId = $request->input('employee_id'); // Ensure your form modal passes employee_id!
    $date       = $request->input('record_date'); // Format: YYYY-MM-DD

    if (!$employeeId || !$date) {
        return redirect()->back()->with('error', 'Unable to resolve employee record metadata target constraints.');
    }

    // 2. Define our matrix mapping form input names to database log_type strings
    $logMatrix = [
        'time_in'   => 'FIRST TIME IN',
        'break_out' => 'FIRST TIME OUT',
        'break_in'  => 'SECOND TIME IN',
        'time_out'  => 'SECOND TIME OUT',
    ];

    // 3. Process each log type sequentially
    foreach ($logMatrix as $inputKey => $logTypeString) {

        // Build query to see if a row for this specific punch already exists
        $existingLogQuery = DB::table('attendance_logs')
            ->where('employee_id', $employeeId)
            ->where('log_date', $date)
            ->where('log_type', $logTypeString);

        if ($request->filled($inputKey)) {
            // Build the complete log_time timestamp (YYYY-MM-DD HH:MM:SS)
            $fullTimestamp = $date . ' ' . $request->input($inputKey) . ':00';

            if ($existingLogQuery->exists()) {
                // UPDATE: Modify the existing log row
                $existingLogQuery->update([
                    'log_time'   => $fullTimestamp,
                    'updated_at' => now()
                ]);
            } else {
                // INSERT: The log didn't exist previously, create it brand new
                DB::table('attendance_logs')->insert([
                    'employee_id' => $employeeId,
                    'log_time'    => $fullTimestamp,
                    'log_type'    => $logTypeString,
                    'log_date'    => $date,
                    'device_name' => 'ADMIN_OVERRIDE_ADJUSTMENT',
                    'created_at'  => now(),
                    'updated_at'  => now()
                ]);
            }
        } else {
            // CLEANUP: If the admin deleted/cleared the time field completely in the modal,
            // wipe out that specific punch entry row from the log table.
            $existingLogQuery->delete();
        }
    }

    return redirect()->back()->with('success', 'Attendance tracking entries compiled and synchronized successfully.');
});

Route::post('/admin/salary/update-inline', [SalaryCalculatorController::class, 'updateInlineDeductions'])->name('admin.salary.update-inline');

    // Reports
    Route::get('/reports',[ReportController::class,'reports']);
    // Factory Reset
    Route::get('/admin/factory-reset', [SettingController::class, 'showResetPage'])->name('admin.reset-page');
    Route::post('/admin/factory-reset/execute', [SettingController::class, 'executeReset'])->name('admin.reset-execute');
    // Logout
    Route::get('/logout', function () {
        session()->forget(['admin_id','admin_username']);
        return redirect('/');
    });




