<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $today = now()->toDateString();

        // 1. Core Summary Counts
        $totalEmployees = DB::table('employees')->count();

        $presentToday = DB::table('attendance_logs')
            ->whereDate('log_date', $today)
            ->where('log_type', 'FIRST TIME IN')
            ->distinct('employee_id')
            ->count();

        $lateToday = DB::table('attendance_logs')
            ->join('employees', 'attendance_logs.employee_id', '=', 'employees.employee_id')
            ->whereDate('attendance_logs.log_date', $today)
            ->where('attendance_logs.log_type', 'FIRST TIME IN')
            ->whereRaw('attendance_logs.log_time::time > employees.schedule_start::time')
            ->distinct('attendance_logs.employee_id')
            ->count();

        $absentToday = max(0, $totalEmployees - $presentToday);

        // 2. Build the Recent Logs Query with Dynamic Filtering
        $query = DB::table('attendance_logs')
            ->join('employees', 'attendance_logs.employee_id', '=', 'employees.employee_id')
            ->select(
                'attendance_logs.*',
                'employees.first_name',
                'employees.last_name'
            );

        // Check if user applied a date filter range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('attendance_logs.log_date', [
                $request->input('start_date'),
                $request->input('end_date')
            ]);
        } else {
            // Default baseline configuration: limit to 10 if unfiltered
            $query->limit(10);
        }

        $recentLogs = $query->latest('attendance_logs.log_time')->get();

        return view('dashboard', compact(
            'totalEmployees',
            'presentToday',
            'lateToday',
            'absentToday',
            'recentLogs'
        ));
    }
}
