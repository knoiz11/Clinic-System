<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees'; // optional, only needed if table name differs

    protected $fillable = [
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'designation',
        'division',
        'department',
        'status',
        'contact',
        'contact_no',
        'email',
        'philhealth_no',
        'sex',
        'birthdate',
        'age',
        'civil_status',
        'religion',
        'blood_type',
        'notes',
        'photo',
        'next_visit',
        'photo',  
    ];

    protected $casts = [
        'birthdate' => 'date',
        'next_visit' => 'datetime',
    ];

        // Compute age from birthdate if available; fallback to stored 'age' column if missing
        public function getAgeAttribute($value)
        {
            if ($this->birthdate) {
                $born = $this->birthdate instanceof Carbon ? $this->birthdate : Carbon::parse($this->birthdate);
                return $born->age;
            }
            return $value;
        }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function employee()
    {
    return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Compatibility: compute 'name' from first/middle/last for existing code that expects $employee->name
    public function getNameAttribute()
    {
        $parts = array_filter([$this->first_name, $this->middle_name, $this->last_name]);
        return implode(' ', $parts);
    }

    // (kept above) accessor computes age; nothing else to do here.

}
