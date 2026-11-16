<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFilmRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title'    => ['required', 'string', 'max:255'],
            'sinopsis' => ['required', 'string'],
            'year'     => ['required', 'integer', 'between:1900,2100'],
            'genre_id' => ['required', 'exists:genres,id'],
            'poster'   => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
