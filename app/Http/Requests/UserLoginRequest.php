<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|exists:users,email',
            'password' => 'required|string',
            'remember' => 'required|bool'
        ];
    }

    public function filters(): array
    {
        return [
            'email' => 'trim|escape',
            'password' => 'trim|escape',
            'remember' => 'cast:boolean'
        ];
    }
}
