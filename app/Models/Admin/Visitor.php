<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $fillable = [
        'resume_id',
        'ip',
        'browser',
        'platform',
        'device',
        'hostname',
        'city',
        'region',
        'country',
        'loc',
        'org',
        'postal',
        'timezone',
    ];
}
