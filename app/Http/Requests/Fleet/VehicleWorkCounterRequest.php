<?php

namespace App\Http\Requests\Fleet;

class VehicleWorkCounterRequest extends BaseFleetRequest
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
            'type' => 'required',
            'current' => 'required|numeric',
            'max' => 'required|numeric',
            'reset' => 'nullable',
            'vehicle_category' => 'required',
            'description' => 'required',
            'operations' => 'nullable|array'
        ];
    }
}
