<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
    {
        // Count of employees
        $employeeCount = Employee::count();

        // Count of upcoming appointments
        $upcomingAppointmentsCount = Appointment::where('date', '>=', now())->count();

        // Placeholder for recent visits for now
        $recentVisitsCount = 0; // or any placeholder number you want

        // Pass all variables to the view
        return view('admin.dashboard', compact(
            'employeeCount',
            'upcomingAppointmentsCount',
            'recentVisitsCount'
        ));
    }
}
