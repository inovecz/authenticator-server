<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\BlacklistTypeEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class BlacklistDatatableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', new Enum(BlacklistTypeEnum::class)],
            'pageLength' => 'required|integer|min:0',
            'page' => 'required|integer|min:0',
            'search' => 'nullable|string',
            'orderBy' => 'nullable|string',
            'sortAsc' => 'nullable|bool',
        ];
    }

    public function filters(): array
    {
        return [
            'type' => 'trim|escape',
            'pageLength' => 'digit',
            'page' => 'digit',
            'search' => 'trim|escape',
            'orderBy' => 'trim|escape',
            'sortAsc' => 'trim|escape|cast:boolean',
        ];
    }
}
