<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

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

    // Compute age from birthdate
    public function getAgeAttribute($value)
    {
        if ($this->birthdate) {
            $born = $this->birthdate instanceof Carbon ? $this->birthdate : Carbon::parse($this->birthdate);
            return $born->age;
        }
        return $value;
    }

    // Compute full name
    public function getNameAttribute()
    {
        $parts = array_filter([$this->first_name, $this->middle_name, $this->last_name]);
        return implode(' ', $parts);
    }

    // Relationships
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function vitalSigns()
    {
        return $this->hasMany(VitalSign::class);
    }

    public function physicalExams()
    {
        return $this->hasMany(PhysicalExam::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function doctorOrders()
    {
        return $this->hasMany(DoctorOrder::class);
    }

    public function laboratories()
    {
        return $this->hasMany(Laboratory::class);
    }
}