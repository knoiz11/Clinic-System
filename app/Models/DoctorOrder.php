<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'doctors_order',
        'prescription',
        'medications_dispensed',
        'order_date',
        'diagnosis',
        'other_diagnosis',
        'icd11_codes',
        'icd11_titles',
        'treatment_plan',
        'disposition',
        'reasons_for_discharge',
        'discharge_datetime',
        'order_remarks',
        'schedule_next',
    ];

    protected $casts = [
        'medications_dispensed' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}