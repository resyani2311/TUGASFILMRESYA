<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user()->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'umur'     => ['required', 'integer', 'between:1,120'],
            'alamat'   => ['required', 'string', 'max:500'],
            'bio'      => ['nullable', 'string', 'max:1000'],
        ];
    }
}
