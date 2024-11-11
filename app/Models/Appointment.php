<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Appointment.php model
    protected $fillable = [
        'user_id',
        'date',
        'time_slot',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'meeting_app',
        'message',
        'meeting_type',
        'decline_message'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
