<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SparePartRequest extends FormRequest
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
            'reference' => 'required',
            'manufacturer' => 'required',
            'unit_price' => 'required|numeric',
            'description' => 'required|max:255',
            'stock' => 'required|numeric',
            'safety_stock' => 'required|numeric',
        ];
    }
}
