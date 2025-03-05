<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FullFormValidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:csv|max:2048',
            'template_name' => 'required|string|max:255|unique:notifications',
        ];
    }
}
