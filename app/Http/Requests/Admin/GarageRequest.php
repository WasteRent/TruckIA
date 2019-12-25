<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GarageRequest extends FormRequest
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
            'email' => 'required|email',
            'phone' => 'required',
            'opening_hours' => 'required',
            'address' => 'required',
            'state' => 'required',
            'province' => 'required',
            'zip' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ];
    }
}
