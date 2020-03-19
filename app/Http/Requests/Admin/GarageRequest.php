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
            'garage_name' => 'nullable',
            'administration_email' => 'nullable|email',
            'administration_phone' => 'nullable',
            'administration_name' => 'nullable',
            'spare_parts_email' => 'nullable|email',
            'spare_parts_phone' => 'nullable',
            'spare_parts_name' => 'nullable',
            'management_email' => 'nullable|email',
            'management_phone' => 'nullable',
            'management_name' => 'nullable',
            'official_service1_manufacturer_id' => 'nullable',
            'official_service2_manufacturer_id' => 'nullable',
            'official_service3_manufacturer_id' => 'nullable',
            'official_service4_manufacturer_id' => 'nullable',
            'official_service5_manufacturer_id' => 'nullable',
            'opening_hours' => 'nullable',
            'address' => 'nullable',
            'state' => 'nullable',
            'province' => 'nullable',
            'zip' => 'nullable',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'hourly_price' => 'nullable|numeric'
        ];
    }
}
