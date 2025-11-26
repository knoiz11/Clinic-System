<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'employee_id',
        'employee_name',
        'date',
        'time',
        'reason',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
        // <-- Explicit foreign key (important!)
    }
}
