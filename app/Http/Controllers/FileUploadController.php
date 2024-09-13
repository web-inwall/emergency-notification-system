<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FileUploadController extends Controller
{
    /*
     * Display a listing of the resource.
     */
    public function uploadFile(Request $request)
    {
        // Валидация загружаемого файла
        $validator = Validator::make(
            [
                'file'      => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:csv', // Только CSV
            ]
        );

        // Проверка на ошибки валидации
        if ($validator->fails()) {
            // Возврат ответа с ошибками валидации
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $file = $request->file('file');

        if (!$file) {
            return response()->json([
                'errors' => ['file' => 'Файл не был выбран.'],
            ], 422);
        }

        // Продолжайте обработку файла

        // Создание уникального имени для файла
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        // Сохранение файла в директорию 'public/uploads'
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        // Чтение данных из файла
        $data = $this->readDataFromFile($file->getPathname(), $file->getClientOriginalExtension());

        // Вставка данных в базу данных
        foreach ($data as $row) {
            // Проверка наличия данных в массиве
            if (isset($row['bio'], $row['link'], $row['adress'])) {
                User::create([
                    'bio' => $row['bio'],
                    'link' => $row['link'],
                    'adress' => $row['adress'],
                ]);
            }
        }

        // Возврат ответа
        // return redirect()->back()->with('success', 'Файл загружен успешно!');
        return 'выполнено';
    }

    private function readDataFromFile($filePath, $extension)
    {
        $data = [];
        if ($extension === 'csv') {
            $data = $this->readCSV($filePath);
        }
        return $data;
    }

    private function readCSV($filePath)
    {
        $data = [];
        $file = fopen($filePath, 'r');
        while (($row = fgetcsv($file)) !== false) {
            $data[] = [
                'bio' => $row[0],
                'link' => $row[1],
                'adress' => $row[2],
            ];
        }
        fclose($file);
        return $data;
    }
}
