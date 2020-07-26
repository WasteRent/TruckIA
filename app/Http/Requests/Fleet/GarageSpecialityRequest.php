<?php

namespace App\Http\Requests\Fleet;

use App\Http\Requests\Fleet\BaseFleetRequest;

class GarageSpecialityRequest extends BaseFleetRequest
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
            'stars'     => 'nullable|numeric|max:5.0'
        ];
    }
}
