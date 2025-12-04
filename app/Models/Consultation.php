<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'chief_complaint',
        'history_illness',
        'diagnosis',
        'treatment_plan',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}