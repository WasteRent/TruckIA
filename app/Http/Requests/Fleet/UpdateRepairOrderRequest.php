<?php

namespace App\Http\Requests\Fleet;

use App\Http\Requests\Fleet\BaseFleetRequest;

class UpdateRepairOrderRequest extends BaseFleetRequest
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
            'type'  => 'nullable',
            'kms'  => 'nullable|numeric',
            'work_hours_chassis' => 'nullable|numeric',
            'work_hours_equipment' => 'nullable|numeric',
            'created_at'  => 'nullable|date',
        ];
    }
}
