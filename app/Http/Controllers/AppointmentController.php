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
        // Fetch all employees for selection in the form
        $employees = Employee::all();

        // Fetch all appointments (with employee info)
        $appointments = Appointment::with('employee')->orderBy('date', 'asc')->get();

        return view('admin.appointment', compact('employees', 'appointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'employee_id' => 'required|exists:employees,id',
            'reason' => 'nullable|string|max:255',
        ], [
            'date.after_or_equal' => 'You cannot book an appointment in the past.',
        ]);


        Appointment::create([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id, // optional if you assign one
            'date' => $request->date,
            'time' => $request->time,
            'reason' => $request->reason,
        ]);

        return redirect()->route('appointment.create')->with('success', 'Appointment booked successfully!');
    }


    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointment.create')->with('success', 'Appointment deleted successfully!');
    }
}
