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
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'employee_id' => 'required|exists:employees,id',
            'reason' => 'required|string|max:255',
        ]);

        Appointment::create([
            'user_id' => Auth::id(),
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'time' => $request->time,
            'reason' => $request->reason,
            'status' => 'Scheduled',
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
