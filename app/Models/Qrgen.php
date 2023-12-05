<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrgen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cardname',
        'firstname',
        'lastname',
        'status',
    ];
}
