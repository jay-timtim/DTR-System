<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{

    public function index()
    {
        $employees = DB::table('employees')->paginate(10);

        return view('manage-employees', compact('employees'));
    }
    public function edit($id)
    {

        $employee = DB::table('employees')
            ->where('employee_id',$id)
            ->first();

        return view('edit',compact('employee'));

    }

    public function update(Request $request,$id)
    {

        $data = $request->except('_token', '_method','photo_path');

        if($request->hasFile('photo_path')){

            $path = $request->file('photo_path')->store('employees','public');

            $data['photo_path'] = $path;

        }

        DB::table('employees')
            ->where('employee_id',$id)
            ->update($data);

        return redirect('/manage-employees')
            ->with('success','Employee updated successfully');

    }

    private function generateEmployeeId()
    {
        do {
            $random = strtoupper(Str::random(6));
            $employeeId = 'EMP-' . $random;

        } while (Employee::where('employee_id', $employeeId)->exists());

        return $employeeId;
    }
    public function store(Request $request)
    {
        $employeeId = $this->generateEmployeeId();

        Employee::create([
            'employee_id' => $employeeId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'address' => $request->address,
            'department' => $request->department,
            'position' => $request->position,
            'date_hired' => $request->date_hired,
            'basic_salary' => $request->basic_salary,
            'employment_status' => $request->employment_status,
            'schedule_start' => $request->schedule_start,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end,
            'schedule_end' => $request->schedule_end,
            'status' => "Active",
        ]);

        return redirect()->back()->with('success','Employee Added');
    }

    public function destroy($id)
    {

        DB::table('employees')
            ->where('employee_id',$id)
            ->delete();

        return redirect()->back()->with('success','Employee deleted');

    }

}
