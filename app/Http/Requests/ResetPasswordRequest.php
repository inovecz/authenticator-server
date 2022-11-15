<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|string|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function filters(): array
    {
        return [
            'email' => 'trim|escape',
            'password' => 'trim|escape',
            'password_confirmation' => 'trim|escape',
        ];
    }
}
