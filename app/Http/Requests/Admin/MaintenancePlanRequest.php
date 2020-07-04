<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MaintenancePlanRequest extends FormRequest
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
            'kms' => 'nullable|numeric',
            'natural_hours' => 'nullable|numeric',
            'work_hours' => 'nullable|numeric',
            'can_hours' => 'nullable|numeric',
            'vehicle_category' => 'required',
            'type' => 'required'
        ];
    }
}
