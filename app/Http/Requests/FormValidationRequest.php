<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormValidationRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Разрешить доступ к запросу
    }

    public function rules()
    {
        return [
            'template_name' => 'required|string|max:255',
            'message' => 'required|string|max:100000',
        ];
    }
}
