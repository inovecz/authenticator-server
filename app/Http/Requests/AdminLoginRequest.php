<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|exists:admins,email',
            'password' => 'required|string',
            'remember' => 'sometimes|required|in:0,1'
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
