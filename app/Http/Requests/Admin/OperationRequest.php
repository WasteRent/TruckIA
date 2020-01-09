<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OperationRequest extends FormRequest
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
            'code' => 'required|unique:operations,code,'.($this->operation ? $this->operation->id : ''),
            'vehicle_type' => 'required',
            'subfamily_id' => 'required',
            'name' => 'required',
            'time_in_hours' => 'nullable|numeric',
            'description' => 'nullable'
        ];
    }
}
