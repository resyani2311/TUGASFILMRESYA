<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'umur'   => ['required', 'integer', 'between:1,120'],
            'alamat' => ['required', 'string', 'max:500'],
            'bio'    => ['nullable', 'string', 'max:1000'],
        ];
    }
}
