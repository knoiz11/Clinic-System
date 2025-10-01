<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('appointment'); // blade with the form
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        Appointment::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return redirect()->route('appointment.create')->with('success', 'Appointment booked successfully!');
    }
}

