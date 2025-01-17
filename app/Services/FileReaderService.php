<?php

namespace App\Services;

use App\Services\FileReaderInterface;
use Exception;

class FileReaderService implements FileReaderInterface
{
    public function readData(string $filePath): array
    {
        $handle = fopen($filePath, 'r'); // Получаем дескриптор файла
        $data = [];
        $batchId = uniqid(); // Генерация уникального идентификатора

        if ($handle !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) == 3 && !empty(trim($row[0])) && !empty(trim($row[1])) && !empty(trim($row[2]))) {
                    $data[] = [
                        'bio' => trim($row[0]),
                        'link' => trim($row[1]),
                        'address' => trim($row[2]),
                        'batch_id' => $batchId, // Добавление уникального идентификатора для пачки данных
                    ];
                }
            }

            fclose($handle);

            if (count($data) > 0) {
                return $data;
            } else {
                throw new Exception('Файл не соответствует формату CSV. Не удалось найти данные в правильном формате.');
            }
        } else {
            throw new Exception('Не удалось открыть файл для чтения.');
        }
    }
}