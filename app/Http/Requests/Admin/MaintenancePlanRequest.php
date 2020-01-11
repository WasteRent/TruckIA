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
            'frequency_type' => 'required',
            'frequency' => 'required',
            'description' => 'nullable'
        ];
    }
}
