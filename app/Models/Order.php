<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'payment_id',
        'package_id',
        'name',
        'phone',
        'email',
        'country',
        'address',
        'zip',
        'amount',
        'district',
        'payment_method',
        'status',
    ];
}
