<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlacklistToogleActiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|int|min:1',
        ];
    }

    public function filters(): array
    {
        return [
            'id' => 'digit',
        ];
    }
}
