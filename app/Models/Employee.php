<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees'; // optional, only needed if table name differs

    protected $fillable = [
        'name',
        'designation',
        'department',
        'status',
        'contact',
        'email',
    ];
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function employee()
    {
    return $this->belongsTo(Employee::class, 'employee_id');
    }

}
