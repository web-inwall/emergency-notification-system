<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageAndFileUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Разрешить доступ к запросу
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ([
            'file' => 'required|file|max:2048',
            'template_name' => 'required|string|max:255',
            'message' => 'required|string|max:100000',
        ]);
    }
}