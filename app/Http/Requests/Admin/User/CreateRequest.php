<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'role_id'  => 'nullable|numeric|in:1,5,9',
            'type_id'  => 'required|numeric',
            'username' => 'required|min:6|max:24',
            'password' => 'required|min:6|max:24',
            'name'     => 'required|max:24',
            'mobile'   => 'nullable|numeric|digits_between:6,20',
            'company'  => 'nullable|max:128',
        ];
    }
}
