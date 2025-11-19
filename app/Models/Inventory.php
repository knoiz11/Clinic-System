<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'object_id',
        'date_purchased',
        'supply_type',
        'item_name',
        'quantity',
        'unit',
        'price',
        'remarks',
    ];
}
