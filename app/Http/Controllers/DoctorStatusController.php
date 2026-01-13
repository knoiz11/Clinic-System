<?php

namespace App\Http\Controllers;

use App\Models\DoctorStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DoctorStatusController extends Controller
{
    public function toggle(Request $request)
    {
        try {
            Log::info('Doctor status toggle started');
            
            $username = Auth::user()->username ?? 'Admin';
            Log::info('Username: ' . $username);
            
            $status = DoctorStatus::toggle($username);
            Log::info('Status toggled successfully', ['is_in' => $status->is_in]);
            
            return response()->json([
                'success' => true,
                'is_in' => $status->is_in,
                'message' => 'Doctor status updated to: ' . ($status->is_in ? 'In' : 'Out')
            ]);
        } catch (\Exception $e) {
            Log::error('Doctor status toggle error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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