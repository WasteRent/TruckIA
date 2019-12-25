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
            'plate' => 'required|unique:vehicles',
            'registration_date' => 'required|date_format:Y-m-d',
            'kms' => 'required|numeric',
            'chassis_maker' => 'required',
            'chassis_model' => 'required',
            'box_maker' => 'required',
            'box_model' => 'required'
        ];
    }
}
