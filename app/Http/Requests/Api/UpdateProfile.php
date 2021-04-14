<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class UpdateProfile extends FormRequest
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
        $user = Auth::user();
        return [
            'username' => ['nullable', 'string', 'max:64', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string',
            'email' => ['nullable', 'email', 'max:64', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'file', 'max:2500', Rule::dimensions()->ratio("1")],
            'first_name' => 'nullable|string|max:64',
            'last_name' => 'nullable|string|max:64',
        ];
    }
}
