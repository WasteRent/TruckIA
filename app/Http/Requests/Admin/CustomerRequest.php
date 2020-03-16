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
            'contact1' => 'required',
            'email1' => 'required|email',
            'phone1' => 'required',
            'contact2' => 'nullable',
            'email2' => 'nullable|email',
            'phone2' => 'nullable',
            'contact3' => 'nullable',
            'email3' => 'nullable|email',
            'phone3' => 'nullable',
            'contact4' => 'nullable',
            'email4' => 'nullable|email',
            'phone4' => 'nullable',

            'address' => 'required',
            'state' => 'required',
            'province' => 'required',
            'zip' => 'required',
        ];
    }
}
