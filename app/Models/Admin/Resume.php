<?php

namespace App\Models\Admin;

use App\Models\User;
use Intervention\Image\ImageManager;
use App\Http\Resources\ResumeResource;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Drivers\Imagick\Driver;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resume extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'template_id',
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
        'fname',
        'lname',
        'profession',
        'city',
        'postal_code',
        'country',
        'other',
        'primary_color',
        'text_color',
        'status',
        'viewcount'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id');
    }

    public function getResume()
    {
        return [
            'id' => $this->id,
            'user' =>  $this->user ? $this->user : 'No user',
            'template_id' => $this->template_id,
            'photo' => $this->photo,
            'resume_name' => $this->resume_name,
            'title' => $this->title,
            'description' => $this->description,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'education' => json_decode($this->education, true),
            'skill' => json_decode($this->skill),
            'language' => json_decode($this->language),
            'interest' => json_decode($this->interest),
            'experience' => json_decode($this->experience),
            'references' => json_decode($this->references),
            'social' => $this->social,
            'fname' => $this->fname,
            'lname' => $this->lname,
            'profession' => $this->profession,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'other' => $this->other,
            'primaryColor' => $this->primary_color,
            'textColor' => $this->text_color,
            'template' => $this->template,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function create_function()
    {

        if (request('photo')) {
            $directory = public_path('image/resume');
            if (!file_exists($directory)) {
                mkdir($directory, 0775, true);
            }

            $manager = new ImageManager(['driver' => 'gd']);
            $name_gen = hexdec(uniqid()) . '.' . request('photo')->getClientOriginalExtension();

            $img = $manager->make(request('photo'));
            $img->save($directory . '/' . $name_gen, 80);

            $this->photo = 'image/resume/' . $name_gen;
        }

        // $this->user_id = auth()->user()->id;
        $this->user_id = request('userId');
        $this->template_id = request('templateId');
        $this->resume_name = request('resume.name');
        $this->title = request('profession');
        $this->description = request('description');
        $this->phone = request('phone');
        $this->email = request('email');
        $this->address = request('address');
        $this->education = request('education');
        $this->skill = request('skills');
        $this->language = request('languages');
        $this->interest = request('interests');
        $this->experience = request('jobs');
        $this->references = request('references');
        $this->social = request('social');
        $this->fname = request('firstName');
        $this->lname = request('lastName');
        $this->primary_color = request('primaryColor');
        $this->text_color = request('textColor');
        $this->profession = request('profession');
        $this->city = request('city');
        $this->postal_code = request('postal_code');
        $this->country = request('country');
        $this->other = request('other');
        $this->save();
        return $this->getResume();
    }
}
