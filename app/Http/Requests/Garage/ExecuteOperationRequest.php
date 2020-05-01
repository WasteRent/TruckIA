<?php

namespace App\Http\Requests\Garage;

use Illuminate\Foundation\Http\FormRequest;

class ExecuteOperationRequest extends FormRequest
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
            'real_time_in_hours' => 'required|numeric|min:0.1',
            'file' => 'nullable|file',
            'observations' => 'nullable'
        ];
    }

    public function attributes()
    {
        return [
            'real_time_in_hours' => 'tiempo invertido',
            'file' => 'archivo',
        ];
    }
}
