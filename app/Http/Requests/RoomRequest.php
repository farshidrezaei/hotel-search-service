<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
            'page' => ['nullable', 'integer', 'min:1'],
            'query'=>['nullable', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
