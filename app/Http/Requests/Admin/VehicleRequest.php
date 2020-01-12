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
            'registration_date' => 'required|date_format:Y-m-d',
            'kms' => 'required|numeric',
            'chassis_maker_id' => 'required',
            'chassis_model_id' => 'required',
            'box_maker_id' => 'nullable',
            'box_model_id' => 'nullable'
        ];
    }
}
