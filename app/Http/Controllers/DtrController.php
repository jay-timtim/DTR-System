<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DtrController extends Controller
{
    public function viewDTR(Request $request)
    {

        $query = DB::table('attendance_logs')
            ->join('employees','employees.employee_id','=','attendance_logs.employee_id')

            ->select(
                'attendance_logs.employee_id',
                'employees.first_name',
                'employees.last_name',

                DB::raw('DATE(log_time) as date'),

                DB::raw("MIN(CASE WHEN log_type='TIME_IN' THEN log_time END) as time_in"),

                DB::raw("MAX(CASE WHEN log_type='BREAK_OUT' THEN log_time END) as break_out"),

                DB::raw("MAX(CASE WHEN log_type='BREAK_IN' THEN log_time END) as break_in"),

                DB::raw("MAX(CASE WHEN log_type='TIME_OUT' THEN log_time END) as time_out")
            );

        /*
        ======================
        FILTERS
        ======================
        */

        // Filter by Employee
        if ($request->employee_id) {
            $query->where('attendance_logs.employee_id', $request->employee_id);
        }

        // Filter Start Date
        if ($request->start_date) {
            $query->whereDate('log_time', '>=', $request->start_date);
        }

        // Filter End Date
        if ($request->end_date) {
            $query->whereDate('log_time', '<=', $request->end_date);
        }

        /*
        ======================
        GROUPING
        ======================
        */

        $records = $query
            ->groupBy(
                'attendance_logs.employee_id',
                'employees.first_name',
                'employees.last_name',
                DB::raw('DATE(log_time)')
            )

            ->orderBy('date','desc')

            ->paginate(15)

            ->appends($request->all()); // keeps filters when paginating


        $employees = DB::table('employees')->get();

        return view('view-dtr', compact('records','employees'));
    }
}
