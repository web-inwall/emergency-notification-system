<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormValidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'template_name' => 'required|string|max:255',
            'message' => 'required|string|max:10000',
        ];
    }
}
