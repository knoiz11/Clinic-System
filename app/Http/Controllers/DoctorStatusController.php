<?php

namespace App\Http\Controllers;

use App\Models\DoctorStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorStatusController extends Controller
{
    public function toggle(Request $request)
    {
        $status = DoctorStatus::toggle(Auth::user()->username ?? 'Admin');
        
        return response()->json([
            'success' => true,
            'is_in' => $status->is_in,
            'message' => 'Doctor status updated to: ' . ($status->is_in ? 'In' : 'Out')
        ]);
    }

    public function getStatus()
    {
        $status = DoctorStatus::getCurrentStatus();
        
        return response()->json([
            'is_in' => $status->is_in,
            'updated_at' => $status->updated_at->diffForHumans(),
        ]);
    }
}