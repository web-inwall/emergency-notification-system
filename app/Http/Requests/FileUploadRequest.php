<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
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
        return [
            'file' => 'required|file|mimes:csv,xml|max:2048', // Правила валидации
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Файл обязателен для загрузки.',
            'file.file' => 'Некорректный файл.',
            'file.mimes' => 'Файл должен быть формата .csv или .xml.',
            'file.max' => 'Максимальный размер файла должен быть 2MB.',
        ];
    }
}
