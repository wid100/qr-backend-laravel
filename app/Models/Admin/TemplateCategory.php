<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function templates()
    {
        return $this->hasMany(Template::class, 'template_category_id');
    }
}
