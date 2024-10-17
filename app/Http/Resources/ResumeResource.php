<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResumeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' =>  $this->user ? $this->user : 'No user',
            'template_id' => $this->template_id,
            'slug' => $this->slug,
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
            'template' => $this->template,
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
            'viewcount' => $this->viewcount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
