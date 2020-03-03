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
            
            'garage_email' => 'nullable|email',
            'garage_phone' => 'nullable',
            'administration_email' => 'nullable|email',
            'administration_phone' => 'nullable',
            'spare_parts_email' => 'nullable|email',
            'spare_parts_phone' => 'nullable',
            'management_email' => 'nullable|email',
            'management_phone' => 'nullable',

            'opening_hours' => 'required',
            'address' => 'required',
            'state' => 'required',
            'province' => 'required',
            'zip' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'hourly_price' => 'required|numeric'
        ];
    }
}
