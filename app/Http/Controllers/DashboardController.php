<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $today = now()->toDateString();

        $totalEmployees = DB::table('employees')->count();

        $presentToday = DB::table('attendance_logs')
            ->whereDate('log_time', $today)
            ->where('log_type','TIME_IN')
            ->distinct('employee_id')
            ->count();

        $lateToday = 0; // You can upgrade later with schedule engine

        $absentToday = $totalEmployees - $presentToday;

        $recentLogs = DB::table('attendance_logs')
            ->join('employees','attendance_logs.employee_id','=','employees.employee_id')
            ->select(
                'attendance_logs.*',
                'employees.first_name',
                'employees.last_name'
            )
            ->latest('attendance_logs.log_time')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalEmployees',
            'presentToday',
            'lateToday',
            'absentToday',
            'recentLogs'
        ));
    }
}
