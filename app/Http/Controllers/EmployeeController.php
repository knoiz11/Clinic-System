<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('components.admin.employee', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sex' => 'nullable|string',
            'designation' => 'nullable|string|max:255',
            'division' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'status' => 'required|string',
            'contact' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'philhealth_no' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'religion' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:255',
            'civil_status' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employee_photos', 'public');
        }

        Employee::create($validated);

        return redirect()->route('employee.index')->with('success', 'Employee added successfully!');
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        return view('admin.employees.view', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_id' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sex' => 'nullable|string',
            'designation' => 'nullable|string|max:255',
            'division' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'status' => 'required|string',
            'contact' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'philhealth_no' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'religion' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:255',
            'civil_status' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $validated['photo'] = $request->file('photo')->store('employee_photos', 'public');
        }

        $employee->update($validated);

        return redirect()->route('employee.show', $employee->id)->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee)
    {
        // Delete photo if exists
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        $employee->delete();

        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully!');
    }
}