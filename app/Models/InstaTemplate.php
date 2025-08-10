<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstaTemplate extends Model
{
    use HasFactory;
    public function instaCategory()
    {
        return $this->belongsTo(InstaCategory::class, 'insta_category');
    }
}
