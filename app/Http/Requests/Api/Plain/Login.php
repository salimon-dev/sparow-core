<?php

namespace App\Http\Requests\Api\Plain;

use Illuminate\Foundation\Http\FormRequest;

class Login extends FormRequest
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
            'username' => 'required|string|max:64',
            'password' => 'required|string',
            'application_token' => 'nullable|string|max:256',
            'scopes' => 'nullable|array',
            'scopes.*' => 'required|string'
        ];
    }
}
