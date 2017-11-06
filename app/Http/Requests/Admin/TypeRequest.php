<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
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
            'name'                => 'required|max:64',
            'introduction'        => 'nullable|max:128',
            'auto_complete_hours' => 'required|numeric|min:0|max:720',
            'auto_complete_stars' => 'required|numeric|min:1|max:5',
            'allow_user_create'   => 'required|boolean',
        ];
    }
}
