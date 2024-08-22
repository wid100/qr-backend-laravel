<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TemplateCreateRequest extends FormRequest
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
            'name' => 'nullable',
            'cat_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'code' => 'nullable',
            'primary_color' => 'required|string',
            'text_color' => 'required|string',
        ];
    }
}
