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

        // For AJAX-based searching we don't need to embed all employees upfront.
        return view('admin.appointment', compact('appointments'));
    }

    // 🔍 Employee Search (AJAX)
    public function searchEmployees(Request $request)
    {
        $query = $request->input('query');
        $employees = Employee::where('first_name', 'LIKE', "%{$query}%")
            ->orWhere('last_name', 'LIKE', "%{$query}%")
            ->orWhere('designation', 'LIKE', "%{$query}%")
            ->orWhere('division', 'LIKE', "%{$query}%")
            ->orWhere('department', 'LIKE', "%{$query}%")
            ->limit(10)
            ->select(['id', 'first_name', 'middle_name', 'last_name', 'designation', 'division', 'department'])
            ->get()
            ->map(function ($e) { // include name via accessor for UI
                return [
                    'id' => $e->id,
                    'name' => $e->name,
                    'designation' => $e->designation,
                    'division' => $e->division,
                    'department' => $e->department,
                ];
            });

        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date'        => 'required|date',
            'time'        => 'required|date_format:H:i',
            'reason'      => 'nullable|string|max:255',
        ]);

        $employee = Employee::find($request->employee_id);

        if (! $employee) {
            return redirect()->route('appointment.create')
                ->withErrors(['employee_id' => 'Selected employee not found.']);
        }

        Appointment::create([
            'employee_id'   => $employee->id,
            'employee_name' => $employee->name,
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
