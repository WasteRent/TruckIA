<?php

namespace App\Http\Requests\Fleet;

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
            'email1' => 'required|email',
            'email2' => 'nullable|email',
            'email3' => 'nullable|email',
            'email4' => 'nullable|email',
        ];
    }
}
