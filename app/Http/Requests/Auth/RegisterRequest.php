<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255',
            'email' => 'required|unique:users,email',
            'phone' => 'required|max:100|unique:users',
            'password' => 'required|confirmed|min:2|max:255'
        ];
    }
}
