<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorStatus extends Model
{
    protected $table = 'doctor_status';
    
    protected $fillable = ['is_in', 'updated_by'];
    
    protected $casts = ['is_in' => 'boolean'];

    public static function getCurrentStatus()
    {
        return self::first() ?? self::create(['is_in' => false]);
    }

    public static function toggle($updatedBy = null)
    {
        $status = self::getCurrentStatus();
        $status->is_in = !$status->is_in;
        $status->updated_by = $updatedBy;
        $status->save();
        return $status;
    }
}