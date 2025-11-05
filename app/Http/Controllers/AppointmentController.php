<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function create()
    {
        $appointments = Appointment::with('employee')
            ->orderBy('date', 'asc')
            ->get();

        $employees = Employee::all();

        return view('admin.appointment', compact('appointments', 'employees'));
    }

public function store(Request $request)
{
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'date'        => 'required|date',
        'time'        => 'required|date_format:H:i',
        'reason'      => 'nullable|string|max:255',
    ]);

    // find employee (will exist because of the validation rule)
    $employee = Employee::find($request->employee_id);

    if (! $employee) {
        return redirect()->route('appointment.create')
            ->withErrors(['employee_id' => 'Selected employee not found.']);
    }

    Appointment::create([
        'employee_id'   => $employee->id,        // <-- property access, NOT a method
        'employee_name' => $employee->name,      // save the employee name
        'date'          => $request->date,
        'time'          => $request->time,
        'reason'        => $request->reason,
        'status'        => 'Scheduled',
        'created_by'    => Auth::id()
    ]);

    return redirect()->route('appointment.create')->with('success', 'Appointment booked successfully!');
}




                       

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Scheduled,Completed,Cancelled',
        ]);

        $appointment->update([
            'status' => $request->status,
        ]);

        return redirect()->route('appointment.create')->with('success', 'Appointment status updated successfully!');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointment.create')->with('success', 'Appointment deleted successfully!');
    }
}
