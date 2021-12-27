<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_name',
        'state_number',
        'color',
        'vin_code',
        'brand',
        'model',
        'year',
        'user_id'
    ];
}
