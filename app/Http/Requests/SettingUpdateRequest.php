<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => 'required|string',
            'value' => 'required|string',
        ];
    }

    public function filters(): array
    {
        return [
            'key' => 'escape|trim',
            'value' => 'escape|trim',
        ];
    }
}
