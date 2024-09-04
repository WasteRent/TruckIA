<?php

namespace App\Http\Requests\Fleet;

use Illuminate\Validation\Rule;

class VehicleRequest extends BaseFleetRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! auth()->user()->is_readonly; // && auth()->user()->job == 'fleet_manager';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'plate' => [
                'required',
                Rule::unique('vehicles')->where(function ($query) {
                    return $query->where('fleet_id', auth()->user()->fleet_id);
                })->ignore($this->route('vehicle')),
            ],
            'registration_date' => 'nullable|date_format:Y-m-d',
            'kms' => 'nullable|numeric',
            'discharged_at' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'chassis_maker_id' => 'required',
            'chassis_model_id' => 'required',
            'update_counters' => 'nullable',
            'internal_id' => 'nullable',
        ];
    }
}
