<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        // Fetch employees and count appointments
        $employees = Employee::withCount('appointments')->get();

        // Fetch all appointments with related employee
        $visits = Appointment::with('employee')->orderBy('date', 'desc')->get();

        return view('admin.reports', compact('employees', 'visits'));
    }

public function generatePDF($type, $mode = 'preview')
{
    $employees = Employee::withCount('appointments')->get();
    $visits = Appointment::with('employee')->orderBy('date', 'desc')->get();

    $data = [
        'type' => $type,
        'employees' => $employees,
        'visits' => $visits,
    ];

    $pdf = Pdf::loadView('admin.pdf', $data)
              ->setPaper('a4', 'portrait');

    // Handle mode
    if ($mode === 'download') {
        return $pdf->download('Clinic-Report-' . ucfirst($type) . '.pdf');
    }

    // Default: stream for preview
    return $pdf->stream('Clinic-Report-' . ucfirst($type) . '.pdf');
}

}
