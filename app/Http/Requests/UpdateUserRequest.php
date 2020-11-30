<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
            'username' => 'required|unique:users,id,'.$this->user->id,
            'password' => 'confirmed',
            'email' => 'required|email|unique:users,id,'.$this->user->id,
            'is_active' => 'nullable|boolean'
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'usuario',
            'name' => 'nombre',
            'email' => 'email',
        ];
    }
}
