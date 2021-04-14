<?php

namespace App\Http\Requests\Api\Plain;

use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
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
            'username' => 'required|string|unique:users|max:64',
            'password' => 'required|string|min:6',
            'email' => 'required|email|max:64|unique:users',
            'phone' => 'nullable|string|max:20|unique:users',
            'avatar' => 'nullable|file|max:2500|dimensions:ratio=1/1',
            // set 3rd party infor
            'application_token' => 'nullable|string|max:256',
            'scopes' => 'nullable|array',
            'scopes.*' => 'required|string',
            'agent' => 'required|string|max:128',
        ];
    }
}
