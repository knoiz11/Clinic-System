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
        'order_date',
        'diagnosis',
        'other_diagnosis',
        'icd11_codes',
        'treatment_plan',
        'disposition',
        'reasons_for_discharge',
        'discharge_datetime',
        'order_remarks',
        'schedule_next',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}