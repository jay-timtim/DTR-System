<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = DB::table('employees')->get();
        return view('manage-employees', compact('employees'));
    }

    public function edit($id)
    {
        $employee = DB::table('employees')
            ->where('employee_id', $id)
            ->first();

        return view('edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        // Keeps deductions data in the update loop request safely
        $data = $request->except('_token', '_method', 'photo_path');

        if ($request->hasFile('photo_path')) {
            $path = $request->file('photo_path')->store('employees', 'public');
            $data['photo_path'] = $path;
        }

        DB::table('employees')
            ->where('employee_id', $id)
            ->update($data);

        return redirect('/manage-employees')
            ->with('success', 'Employee updated successfully');
    }

    public function store(Request $request)
    {
        // Validation including numerical deduction requirements
        $request->validate([
            'employee_id'          => 'required|string|unique:employees,employee_id',
            'first_name'           => 'required|string',
            'last_name'            => 'required|string',
            'basic_salary'         => 'required|numeric|min:0',
            'sss_deduction'        => 'required|numeric|min:0',
            'pagibig_deduction'    => 'required|numeric|min:0',
            'philhealth_deduction' => 'required|numeric|min:0',
            'other_deductions'     => 'required|numeric|min:0',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo_path')) {
            $photoPath = $request->file('photo_path')->store('employees', 'public');
        }

        Employee::create([
            'employee_id'          => strip_tags(trim($request->employee_id)),
            'first_name'           => $request->first_name,
            'last_name'            => $request->last_name,
            'middle_name'          => $request->middle_name,
            'birthday'             => $request->birthday,
            'gender'               => $request->gender,
            'address'              => $request->address,
            'department'           => $request->department,
            'position'             => $request->position,
            'date_hired'           => $request->date_hired,
            'basic_salary'         => $request->basic_salary,
            'employment_status'    => $request->employment_status,

            // Deductions Field Integration mapping parameters
            'sss_deduction'        => $request->sss_deduction ?? 0.00,
            'pagibig_deduction'    => $request->pagibig_deduction ?? 0.00,
            'philhealth_deduction' => $request->philhealth_deduction ?? 0.00,
            'other_deductions'     => $request->other_deductions ?? 0.00,

            'schedule_start'       => $request->schedule_start,
            'break_start'          => $request->break_start,
            'break_end'            => $request->break_end,
            'schedule_end'         => $request->schedule_end,
            'photo_path'           => $photoPath,
            'status'               => "Active",
        ]);

        return redirect()->back()->with('success', 'Employee registered successfully!');
    }

    public function destroy($id)
    {
        DB::table('employees')
            ->where('employee_id', $id)
            ->delete();

        return redirect()->back()->with('success', 'Employee deleted');
    }

    public function showIdGenerator()
    {
        $employees = DB::table('employees')
            ->select('employee_id', 'first_name', 'last_name', 'department', 'position', 'photo_path')
            ->orderBy('last_name', 'asc')
            ->get();

        return view('id-generator', compact('employees'));
    }
}
