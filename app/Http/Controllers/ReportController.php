<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function reports(Request $request)
    {
        $query = DB::table('attendance_logs')
            ->join('employees','attendance_logs.employee_id','=','employees.employee_id')
            ->select(
                'attendance_logs.*',
                'employees.first_name',
                'employees.last_name'
            );

        if($request->employee_id){
            $query->where('attendance_logs.employee_id',$request->employee_id);
        }

        if($request->start_date && $request->end_date){
            $query->whereBetween('attendance_logs.log_time',[
                $request->start_date,
                $request->end_date
            ]);
        }

        $records = DB::table('attendance_logs as a')
            ->join('employees as e','a.employee_id','=','e.employee_id')
            ->select(
                'a.employee_id',
                'e.first_name',
                'e.last_name',
                DB::raw("DATE(a.log_time) as attendance_date"),

                DB::raw("MIN(CASE WHEN a.log_type = 'FIRST TIME IN' THEN a.log_time END) as time_in"),

                DB::raw("MAX(CASE WHEN a.log_type = 'SECOND TIME OUT' THEN a.log_time END) as time_out"),

                DB::raw("MAX(a.log_type) as status")
            )
            ->groupBy(
                'a.employee_id',
                'e.first_name',
                'e.last_name',
                DB::raw("DATE(a.log_time)")
            )
            ->latest('attendance_date')
            ->paginate(20);

        $employees = DB::table('employees')->get();

        $totalAttendance = DB::table('attendance_logs')->count();

        $mostPresentEmployee = DB::table('attendance_logs')
            ->select('employee_id', DB::raw('count(*) as total'))
            ->groupBy('employee_id')
            ->orderByDesc('total')
            ->first();

        $mostPresentName = null;

        if($mostPresentEmployee){
            $emp = DB::table('employees')
                ->where('employee_id',$mostPresentEmployee->employee_id)
                ->first();

            $mostPresentName = $emp->first_name.' '.$emp->last_name;
        }

        $lateToday = 0;

        return view('reports', compact(
            'records',
            'employees',
            'totalAttendance',
            'mostPresentName',
            'lateToday'
        ));
    }
}
