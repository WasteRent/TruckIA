<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $user = auth()->user();

        return [
            'name' => 'required',
            'password' => 'confirmed',
            //'email' => "required|email|unique:users,email,{$user->id},id,deleted_at,NULL",
            'is_active' => 'nullable|boolean',
            'allowed_customer_id' => 'nullable',
            'job' => 'nullable'
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
