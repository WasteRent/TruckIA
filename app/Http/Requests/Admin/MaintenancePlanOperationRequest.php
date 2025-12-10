<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MaintenancePlanOperationRequest extends FormRequest
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
            'family_id' => 'required',
            'subfamily_id' => 'nullable',
            'name' => 'required',
            'time_in_hours' => 'required|numeric',
            'description' => 'nullable',
            'attachment' => 'nullable|file',
        ];
    }
}
