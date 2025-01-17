<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        // Валидация загружаемого файла
        $request->validate([
            'file' => 'required|file|mimes:csv|max:2048', // Ограничение по размеру файла
        ]);

        $file = $request->file('file');

        // Чтение данных из файла
        $data = $this->readDataFromFile($file->getPathname());

        // Вставка данных в базу данных
        $this->insertUsers($data);

        return response()->json(['message' => 'Выполнено'], 200);
    }

    private function readDataFromFile(string $filePath): array
    {
        return $this->readCSV($filePath);
    }

    private function readCSV(string $filePath): array
    {
        $data = [];

        if (($file = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($file)) !== false) {
                if (count($row) >= 3) { // Проверка на количество колонок
                    $data[] = [
                        'bio' => $row[0],
                        'link' => $row[1],
                        'adress' => $row[2],
                    ];
                }
            }
            fclose($file);
        } else {
            throw new \Exception('Не удалось открыть файл.');
        }

        return $data;
    }

    private function insertUsers(array $data): void
    {
        foreach ($data as $row) {
            if (!empty($row['bio']) && !empty($row['link']) && !empty($row['adress'])) {
                User::create([
                    'bio' => $row['bio'],
                    'link' => $row['link'],
                    'adress' => $row['adress'],
                ]);
            }
        }
    }
}