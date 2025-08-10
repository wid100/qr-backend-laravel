<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'discount_price',
        'description',
        'front_image',
        'back_image',
        'status',
    ];
}
