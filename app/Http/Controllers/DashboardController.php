<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Appointment;
use Carbon\Carbon;

class DashboardController extends Controller
{
public function index()
{
    // Count of employees
    $employeeCount = Employee::count();

    // Count of upcoming appointments
    $upcomingAppointmentsCount = Appointment::where('status', '!=', 'completed')
        ->where(function($query) {
            $query->where('date', '>', now()->toDateString())
                ->orWhere(function($q) {
                    $q->where('date', now()->toDateString())
                        ->where('time', '>=', now()->format('H:i:s'));
                });
        })
        ->count();

    // Upcoming appointments (limit 5)
    $upcomingAppointments = Appointment::where('status', '!=', 'completed')
        ->where(function($query) {
            $query->where('date', '>', now()->toDateString())
                ->orWhere(function($q) {
                    $q->where('date', now()->toDateString())
                        ->where('time', '>=', now()->format('H:i:s'));
                });
        })
        ->orderBy('date', 'asc')
        ->orderBy('time', 'asc')
        ->take(5)
        ->get();


    // Latest employees (limit 5)
    $employees = Employee::latest()->take(5)->get();

    // Recent visits (latest completed appointments, limit 5)
    $recentVisits = Appointment::where('status', 'completed')
        ->orderBy('date', 'desc')
        ->orderBy('time', 'desc')
        ->take(5)
        ->get();

    $recentVisitsCount = $recentVisits->count();

    return view('admin.dashboard', compact(
        'employeeCount',
        'upcomingAppointmentsCount',
        'employees',
        'upcomingAppointments',
        'recentVisits',
        'recentVisitsCount'
    ));
}


}
