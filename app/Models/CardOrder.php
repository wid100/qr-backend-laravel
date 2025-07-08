<?php

namespace App\Models;

use App\Models\Admin\SmartCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CardOrder extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function smartCard()
    {
        return $this->belongsTo(SmartCard::class);
    }
    public function qrgen()
    {
        return $this->belongsTo(Qrgen::class, 'qrgen_id');
    }
}
