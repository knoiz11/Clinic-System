<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'blood_chemistry',
        'blood_oxygenation',
        'complete_blood_count',
        'immunology',
        'clinical_chemistry',
        'fecalysis',
        'serology',
        'sputum_microscopy',
        'urinalysis',
        'hematology',
        'administered_by',
        'remarks',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}