<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQSection extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'status',
    ];
    public function questions()
    {
        return $this->hasMany(FAQQuestion::class, 'f_a_q_section_id');
    }
}
