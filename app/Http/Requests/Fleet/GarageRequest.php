<?php

namespace App\Http\Requests\Fleet;

class GarageRequest extends BaseFleetRequest
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
            'cif' => 'nullable|string',
            'garage_email' => 'nullable|email',
            'administration_email' => 'nullable|email',
            'spare_parts_email' => 'nullable|email',
            'management_email' => 'nullable|email',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'hourly_price' => 'nullable|numeric',
            'is_manager' => 'nullable|boolean',
        ];
    }
}
