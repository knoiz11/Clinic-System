<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'test_type',
        'test_results',
        'test_date',
        'conducted_by',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}