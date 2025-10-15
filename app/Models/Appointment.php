<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Allow these columns to be mass assignable
    protected $fillable = [
        'user_id',
        'employee_id', // new
        'date',
        'time',
        'reason', // new
    ];

    // Relationship: Appointment belongs to an Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Optional: Appointment belongs to a User (creator/patient)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
