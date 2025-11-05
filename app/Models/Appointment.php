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
        'date',
        'time',
        'reason',
        'status',
        'employee_name',
    ];      

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
