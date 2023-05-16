<?php

namespace App\Http\Requests\Fleet;

class VehicleRequest extends BaseFleetRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $allowed_users = [
            892, //beatriz
            928, //vvictor
            955, //luciano
            637, //yo
            951, //jgarciasoto
        ];
        return ! auth()->user()->is_readonly && in_array(auth()->id(), $allowed_users);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'plate' => 'required',
            'registration_date' => 'nullable|date_format:Y-m-d',
            'kms' => 'nullable|numeric',
            'discharged_at' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'chassis_maker_id' => 'required',
            'chassis_model_id' => 'required',
            'update_counters' => 'nullable'
        ];
    }
}
