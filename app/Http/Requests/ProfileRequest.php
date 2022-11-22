<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
            'username' => 'required|unique:users,id,'.Auth::user()->id,
            'password' => 'nullable|string|confirmed',
            'name' => 'required',
            'can_email_alerts' => 'nullable',
            //'email' => 'required|email',
            'email' => "required|email|unique:users,email,{$user->id},id,deleted_at,NULL",
            'avatar' => 'nullable|image|dimensions:max_width=600,max_height=600',
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'usuario',
            'password' => 'password',
            'name' => 'nombre',
        ];
    }
}
