<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'password' => 'nullable|min:6|max:24',
            'name'     => 'required|max:24',
            'mobile'   => 'nullable|numeric|digits_between:6,20',
            'company'  => 'nullable|max:128',
        ];
    }
}
