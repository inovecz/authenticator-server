<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use App\Enums\GenderEnum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrCreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->prepareRules($this->hash);
    }

    public function filters(): array
    {
        return [
            'hash' => 'trim|escape',
            'name' => 'trim|escape',
            'surname' => 'trim|escape',
            'gender' => 'trim|escape',
            'email' => 'trim|escape',
            'phone' => 'trim|escape|empty_string_to_null',
        ];
    }

    public function prepareRules(?string $hash = null): array
    {
        if (isset($hash) && $user = User::where('hash', $hash)->first()) {
            $emailRule = ['required', 'email', Rule::unique('users', 'email')->ignore($user)];
            $phoneRule = ['nullable', 'regex:/\+[0-9]{6,15}/', Rule::unique('users', 'phone')->ignore($user)];
        } else {
            $emailRule = 'required|email|unique:users,email';
            $phoneRule = 'nullable|regex:/\+[0-9]{6,15}/';
        }

        return [
            'hash' => 'sometimes|required|exists:users,hash',
            'name' => 'required|string',
            'surname' => 'required|string',
            'gender' => ['sometimes', 'nullable', new Enum(GenderEnum::class)],
            'email' => $emailRule,
            'phone' => $phoneRule,
            'password' => ['sometimes', 'required_without:hash', Password::min(8)->letters()->mixedCase()->numbers(), 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required_without' => 'Při vytváření uživatele je heslo povinné',
        ];
    }
}
