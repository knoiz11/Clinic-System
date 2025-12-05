<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'body_temperature',
        'heart_rate',
        'pulse_rate',
        'bp_systolic',
        'bp_diastolic',
        'respiratory_rate',
        'bp_assessment',
        'administered_by',
        'remarks',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
