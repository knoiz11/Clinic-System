<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('admin.employee', compact('employees')); 
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'employee_id' => 'nullable|string|max:32|unique:employees,employee_id',
            'designation' => 'nullable|string|max:100',
            'division'    => 'nullable|string|max:100',
            'department'  => 'nullable|string|max:100',
            'status'      => 'nullable|string|max:50',
            'contact'     => 'nullable|string|max:20',
            'contact_no'  => 'nullable|string|max:20',
            'email'       => 'nullable|email|unique:employees',
            'philhealth_no' => 'nullable|string|max:50',
            'sex'         => 'nullable|string|max:20',
            'birthdate'   => 'nullable|date',
            'civil_status'=> 'nullable|string|max:20',
            'religion'    => 'nullable|string|max:50',
            'blood_type'  => 'nullable|string|max:10',
            'notes'       => 'nullable|string',
            'photo'       => 'nullable|string',
            'next_visit'  => 'nullable|date',
        ]);

        $data = $request->only([
            'employee_id', 'first_name', 'middle_name', 'last_name', 'designation', 'division', 'department', 'status', 'contact', 'contact_no', 'email', 'philhealth_no', 'sex', 'birthdate', 'civil_status', 'religion', 'blood_type', 'notes', 'photo', 'next_visit'
        ]);
        // Backwards compatibility: map employment_status only when it matches allowed core status values
        if ($request->filled('employment_status') && empty($data['status'])) {
            $employment = $request->input('employment_status');
            $allowedCoreStatuses = ['Active', 'Inactive', 'On Leave'];
            if (in_array($employment, $allowedCoreStatuses, true)) {
                $data['status'] = $employment;
            }
        }

        if (empty($data['contact_no']) && !empty($data['contact'])) {
            $data['contact_no'] = $data['contact'];
        }

        // Compute age from birthdate to maintain correct DB value even if user doesn't supply 'age'
        if (!empty($data['birthdate'])) {
            $data['age'] = Carbon::parse($data['birthdate'])->age;
        }

        Employee::create($data);

        return redirect()->route('employee.index')->with('success', 'Employee added successfully');
    }

    public function show(Employee $employee)
    {
        return view('admin.employees.view', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'employee_id' => 'nullable|string|max:32|unique:employees,employee_id,'.$employee->id,
            'designation' => 'nullable|string|max:100',
            'division'    => 'nullable|string|max:100',
            'department'  => 'nullable|string|max:100',
            'status'      => 'nullable|string|max:50',
            'contact'     => 'nullable|string|max:20',
            'contact_no'  => 'nullable|string|max:20',
            'email'       => 'nullable|email|unique:employees,email,'.$employee->id,
            'philhealth_no' => 'nullable|string|max:50',
            'sex'         => 'nullable|string|max:20',
            'birthdate'   => 'nullable|date',
            'civil_status'=> 'nullable|string|max:20',
            'religion'    => 'nullable|string|max:50',
            'blood_type'  => 'nullable|string|max:10',
            'notes'       => 'nullable|string',
            'photo'       => 'nullable|string',
            'next_visit'  => 'nullable|date',
        ]);

        $data = $request->only([
            'employee_id', 'first_name', 'middle_name', 'last_name', 'designation', 'division', 'department', 'status', 'contact', 'contact_no', 'email', 'philhealth_no', 'sex', 'birthdate', 'civil_status', 'religion', 'blood_type', 'notes', 'photo', 'next_visit'
        ]);
        // Backwards compatibility: map employment_status only when it matches allowed core status values
        if ($request->filled('employment_status') && empty($data['status'])) {
            $employment = $request->input('employment_status');
            $allowedCoreStatuses = ['Active', 'Inactive', 'On Leave'];
            if (in_array($employment, $allowedCoreStatuses, true)) {
                $data['status'] = $employment;
            }
        }

        if (empty($data['contact_no']) && !empty($data['contact'])) {
            $data['contact_no'] = $data['contact'];
        }

        // Compute age from birthdate during update process as well
        if (!empty($data['birthdate'])) {
            $data['age'] = Carbon::parse($data['birthdate'])->age;
        }

        $employee->update($data);

        return redirect()->route('employee.index')->with('success', 'Employee updated successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully');
    }
}
