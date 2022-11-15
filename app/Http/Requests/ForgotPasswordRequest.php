<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|exists:users,email',
        ];
    }

    public function filters(): array
    {
        return [
            'email' => 'trim|escape',
        ];
    }
}
