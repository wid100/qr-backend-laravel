<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResumeRequest extends FormRequest
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'resume_name' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
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
