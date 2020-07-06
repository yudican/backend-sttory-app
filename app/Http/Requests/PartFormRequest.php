<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartFormRequest extends FormRequest
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
            'part_title' => ['required', 'string'],
            'part_description' => ['required', 'string'],
            'part_cover' => ['image'],
        ];
    }
}
