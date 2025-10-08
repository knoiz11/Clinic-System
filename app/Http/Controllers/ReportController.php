<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Appointment;

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
}
