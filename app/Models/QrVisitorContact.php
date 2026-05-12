<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrVisitorContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'qrgen_id',
        'visitor_name',
        'visitor_phone',
        'note',
        'ip',
    ];

    public function qrgen()
    {
        return $this->belongsTo(Qrgen::class, 'qrgen_id');
    }
}
