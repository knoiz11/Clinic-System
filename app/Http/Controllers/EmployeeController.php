<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

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
            'name'        => 'required|string|max:255',
            'designation' => 'nullable|string|max:100',
            'department'  => 'nullable|string|max:100',
            'status'      => 'nullable|string|max:50',
            'contact'     => 'nullable|string|max:20',
            'email'       => 'nullable|email|unique:employees',
        ]);

        Employee::create($request->only('name','designation','department','status','contact','email'));

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
            'name'        => 'required|string|max:255',
            'designation' => 'nullable|string|max:100',
            'department'  => 'nullable|string|max:100',
            'status'      => 'nullable|string|max:50',
            'contact'     => 'nullable|string|max:20',
            'email'       => 'nullable|email|unique:employees,email,'.$employee->id,
        ]);

        $employee->update($request->only('name','designation','department','status','contact','email'));

        return redirect()->route('employee.index')->with('success', 'Employee updated successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully');
    }
}
