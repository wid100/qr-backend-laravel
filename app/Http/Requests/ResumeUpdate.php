<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResumeUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'photo' => 'nullable|image|max:2048',
            'resume_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:255',
            'education' => 'nullable|string',
            'skill' => 'nullable|string',
            'language' => 'nullable|string',
            'interest' => 'nullable|string',
            'experience' => 'nullable|string',
            'references' => 'nullable|string',
            'social' => 'nullable|string',
        ];
    }
}
