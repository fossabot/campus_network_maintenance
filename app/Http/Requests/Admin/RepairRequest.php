<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RepairRequest extends FormRequest
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
            'user_id'            => 'required|numeric|digits_between:6,20',
            'user_name'          => 'required|max:10',
            'user_mobile'        => 'required|numeric|digits_between:6,20',
            'type_id'            => 'required|numeric|min:1',
            'location_id'        => 'required|numeric|min:1',
            'user_room'          => 'required|max:50',
            'user_description'   => 'required|min:5|max:1000',
            'repair_description' => 'nullable|max:1000',
        ];
    }
}
