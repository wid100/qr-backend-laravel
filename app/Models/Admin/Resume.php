<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'photo',
        'resume_name',
        'title',
        'description',
        'phone',
        'email',
        'address',
        'education',
        'skill',
        'language',
        'interest',
        'experience',
        'references',
        'social',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getResume()
    {
        return [
            'user' =>  $this->user ? $this->user : 'No user',
            'photo' => $this->photo,
            'resume_name' => $this->resume_name,
            'title' => $this->title,
            'description' => $this->description,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'education' => $this->education,
            'skill' => $this->skill,
            'language' => $this->language,
            'interest' => $this->interest,
            'experience' => $this->experience,
            'references' => $this->references,
            'social' => $this->social,
        ];
    }
}
