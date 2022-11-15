<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'surname' => 'required|string',
            'gender' => ['sometimes', new Enum(GenderEnum::class)],
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function filters(): array
    {
        return [
            'name' => 'trim|escape',
            'surname' => 'trim|escape',
            'gender' => 'trim|escape',
            'email' => 'trim|escape',
            'password' => 'trim|escape',
            'password_confirmation' => 'trim|escape',
        ];
    }
}
