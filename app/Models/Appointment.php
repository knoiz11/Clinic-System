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
        'date',
        'time',
    ];
}
