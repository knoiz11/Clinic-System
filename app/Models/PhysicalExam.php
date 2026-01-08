<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'head',
        'conjunctiva_pale',
        'conjunctiva_yellowish',
        'conjunctiva_remarks',
        'neck_enlarged_thyroid',
        'neck_enlarged_lymph',
        'thorax_abnormal_cardiac',
        'thorax_abnormal_breathing',
        'thorax_remarks',
        'chest',
        'breast_mass',
        'breast_nipple_discharge',
        'breast_skin_orange',
        'breast_enlarged_nodes',
        'breast_remarks',
        'abdomen_enlarged_liver',
        'abdomen_mass',
        'abdomen_scar',
        'abdomen_tenderness',
        'abdomen_remarks',
        'others',
        'administered_by',
        'remarks',
    ];

    protected $casts = [
        // Removed boolean casts to match doctor's order pattern
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}