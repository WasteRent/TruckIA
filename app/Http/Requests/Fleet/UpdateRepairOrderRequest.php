<?php

namespace App\Http\Requests\Fleet;

class UpdateRepairOrderRequest extends BaseFleetRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return in_array(auth()->user()->job, ['fleet_manager', 'garage_boss', 'mechanic']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'nullable',
            'kms' => 'nullable|numeric',
            'work_hours_chassis' => 'nullable|numeric',
            'work_hours_equipment' => 'nullable|numeric',
            'created_at' => 'nullable|date',
            'workshop_exit_date' => 'nullable|date',
            'workshop_date' => 'nullable|date',
            'identificator' => 'nullable',
            'itv_file_id' => 'nullable',
            'left_the_workshop' => 'nullable',
            'sinister' => 'nullable',
            'misuse' => 'nullable',
            'authorized_at' => 'date',
        ];
    }
}
