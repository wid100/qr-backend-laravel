<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'answer',
        'f_a_q_section_id',
        'status'
    ];
    public function section()
    {
        return $this->belongsTo(FAQSection::class, 'f_a_q_section_id');
    }
}
