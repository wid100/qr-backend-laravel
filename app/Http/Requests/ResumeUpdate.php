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
            'resume' => 'required',
            'title' => 'nullable',
            'description' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable',
            'education' => 'nullable',
            'skill' => 'nullable',
            'language' => 'nullable',
            'interest' => 'nullable',
            'experience' => 'nullable',
            'references' => 'nullable',
            'social' => 'nullable',
        ];
    }
}
