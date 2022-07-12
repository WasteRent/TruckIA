<?php

namespace App\Http\Requests\Fleet;

class VehicleEquipmentRequest extends BaseFleetRequest
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
            'maker_id' => 'required',
            'model_id' => 'required',
            'warranty_date' => 'nullable|date',
            'plate' => 'nullable',
            'bomb_serial_number' => 'nullable',
            'bomb_maker' => 'nullable',
            'bomb_model' => 'nullable',
            'picture' => 'nullable|image',
        ];
    }
}
