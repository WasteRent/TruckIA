<?php

namespace App\Http\Requests\Admin;

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
            'fleet_id' => 'required',
            'plate' => 'required|unique:vehicles,plate,'.($this->vehicle ? $this->vehicle->id : ''),
            'registration_date' => 'nullable|date_format:Y-m-d',
            'kms' => 'nullable|numeric',
            'vin'                   => 'nullable',
            'equipment_plate'       => 'nullable',
            'discharged_at'         => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'chassis_maker_id'      => 'required',
            'chassis_model_id'      => 'required',
            'equipment_maker_id'    => 'nullable',
            'equipment_model_id'    => 'nullable',
            'equipment_maker2_id'   => 'nullable',
            'equipment_model2_id'   => 'nullable',
            'equipment_maker3_id'   => 'nullable',
            'equipment_model3_id'   => 'nullable',
            'warranty_chassis'      => 'nullable|date_format:Y-m-d',
            'warranty_equipment1'   => 'nullable|date_format:Y-m-d',
            'warranty_equipment2'   => 'nullable|date_format:Y-m-d',
            'warranty_equipment3'   => 'nullable|date_format:Y-m-d',
        ];
    }
}
