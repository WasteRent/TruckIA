<?php

namespace App\Http\Requests\Garage;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
            'vehicle_id' => 'required',
            'repair_order_id' => 'required',
            'date_time' => 'required|date',
            'notes' => 'nullable'
        ];
    }
}
