<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DtrController extends Controller
{
    public function viewDtr(Request $request)
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

        $records = $query->latest('attendance_logs.log_time')
            ->paginate(20);

        $employees = DB::table('employees')->get();

        return view('view-dtr',compact('records','employees'));
    }
}
