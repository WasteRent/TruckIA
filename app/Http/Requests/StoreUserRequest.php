<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username' => 'required|unique:users,email,NULL,NULL,deleted_at,NULL',
            'password' => 'required',
            'job' => 'nullable',
            'email' => 'nullable|unique:users,email,NULL,NULL,deleted_at,NULL',
            'is_active' => 'nullable|boolean',
            'allowed_schedule' => 'nullable'
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'usuario',
            'name' => 'nombre',
        ];
    }
}
