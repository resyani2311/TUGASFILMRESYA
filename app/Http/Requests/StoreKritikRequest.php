<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKritikRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role?->name === 'user';
    }

    public function rules(): array
    {
        return [
            'comment' => ['required', 'string', 'min:3', 'max:1000'],
            'rating'  => ['required', 'integer', 'between:1,5'],
        ];
    }
}
