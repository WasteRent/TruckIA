<?php

namespace App\Http\Requests\Fleet;

class EnterpriseGroupRequest extends BaseFleetRequest
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
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'contact' => 'nullable',
            'address' => 'nullable',
        ];
    }
}
