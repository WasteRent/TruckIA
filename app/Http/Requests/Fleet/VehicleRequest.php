<?php

namespace App\Http\Requests\Fleet;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'plate' => 'required|unique:vehicles,plate,'.($this->vehicle ? $this->vehicle->id : ''),
            'registration_date' => 'nullable|date_format:Y-m-d',
            'kms' => 'nullable|numeric',
            'discharged_at'         => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'chassis_maker_id'      => 'required',
            'chassis_model_id'      => 'required',
        ];
    }
}
