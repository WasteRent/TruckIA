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
            'manufacturer_id' => 'required',
            'model_id' => 'required',
            'frequency_type_1' => 'required',
            'frequency_1' => 'required|numeric',
            'frequency_type_2' => 'nullable',
            'frequency_2' => 'nullable|numeric',
            'frequency_type_3' => 'nullable',
            'frequency_3' => 'nullable|numeric',
            'description' => 'nullable'
        ];
    }
}
