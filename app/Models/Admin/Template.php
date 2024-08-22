<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;
    protected $fillable = [
        'template_category_id',
        'name',
        'image',
        'code',
        'primary_color',
        'text_color'
    ];
}
