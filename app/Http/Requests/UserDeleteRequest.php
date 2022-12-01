<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hash' => 'required|exists:users,hash',
        ];
    }

    public function filters(): array
    {
        return [
            'hash' => 'trim|escape',
        ];
    }
}
