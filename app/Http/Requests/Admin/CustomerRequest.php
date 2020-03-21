<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'required',
            'enterprise_group_id' => 'required',
            'contact1' => 'nullable',
            'email1' => 'nullable|email',
            'phone1' => 'nullable',
            'contact2' => 'nullable',
            'email2' => 'nullable|email',
            'phone2' => 'nullable',
            'contact3' => 'nullable',
            'email3' => 'nullable|email',
            'phone3' => 'nullable',
            'contact4' => 'nullable',
            'email4' => 'nullable|email',
            'phone4' => 'nullable',

            'address' => 'nullable',
            'state' => 'nullable',
            'province' => 'nullable',
            'zip' => 'nullable',
        ];
    }
}
