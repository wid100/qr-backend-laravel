<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstaCategory extends Model
{
    use HasFactory;
    public function instaTemplates()
    {
        return $this->hasMany(InstaTemplate::class, 'insta_category');
    }
}
