<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'general_appearance',
        'head_neck',
        'chest_lungs',
        'heart_cardiovascular',
        'abdomen',
        'extremities',
        'additional_notes',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}