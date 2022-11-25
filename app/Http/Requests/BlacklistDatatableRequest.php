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
            'page_length' => 'sometimes|nullable|integer|min:0',
            'page' => 'sometimes|nullable|integer|min:0',
            'search' => 'sometimes|nullable|string',
            'order_by' => 'sometimes|nullable|string',
            'sort_asc' => 'sometimes|nullable|in:1,0,true,false',
        ];
    }

    public function filters(): array
    {
        return [
            'type' => 'trim|escape',
            'page_length' => 'digit',
            'page' => 'digit',
            'search' => 'trim|escape',
            'order_by' => 'trim|escape',
            'sort_asc' => 'trim|escape|cast:boolean',
        ];
    }
}
