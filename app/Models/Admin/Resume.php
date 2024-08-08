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

    public function create_function()
    {
        // $this->user_id = auth()->user()->id;
        $this->user_id = 1;
        $this->photo = request('photo');
        $this->resume_name = request('resume_name');
        $this->title = request('title');
        $this->description = request('description');
        $this->phone = request('phone');
        $this->email = request('email');
        $this->address = request('address');
        $this->education = request('education');
        $this->skill = request('skill');
        $this->language = request('language');
        $this->interest = request('interest');
        $this->experience = request('experience');
        $this->references = request('references');
        $this->social = request('social');
        $this->save();
        return $this->getResume();
    }

    public function update_resume()
    {
        $this->photo = request('photo');
        $this->resume_name = request('resume_name');
        $this->title = request('title');
        $this->description = request('description');
        $this->phone = request('phone');
        $this->email = request('email');
        $this->address = request('address');
        $this->education = request('education');
        $this->skill = request('skill');
        $this->language = request('language');
        $this->interest = request('interest');
        $this->experience = request('experience');
        $this->references = request('references');
        $this->social = request('social');
        $this->save();
        return $this->getResume();
    }
}
