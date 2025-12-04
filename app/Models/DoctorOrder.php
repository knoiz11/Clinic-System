<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'medication_orders',
        'lab_tests_ordered',
        'special_instructions',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}