<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'date',
        'time',
        'reason',
        'status',
        'patient_name',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
