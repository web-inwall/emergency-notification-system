<?php

namespace App\Services;

use App\Interfaces\FileReaderInterface;
use Exception;

class FileReaderService implements FileReaderInterface
{
    public function readData(string $filePath): array
    {
        $handle = fopen($filePath, 'r'); // Получаем дескриптор файла
        $csvData = [];
        $batchId = uniqid(); // Генерация уникального идентификатора

        if ($handle !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) == 3 && ! empty(trim($row[0])) && ! empty(trim($row[1])) && ! empty(trim($row[2]))) {
                    $csvData[] = [
                        'bio' => trim($row[0]),
                        'link' => trim($row[1]),
                        'address' => trim($row[2]),
                        'batch_id' => $batchId, // Добавление уникального идентификатора для пачки данных
                    ];
                }
            }

            fclose($handle);

            if (count($csvData) > 0) {
                return ['batchId' => $batchId, 'data' => $csvData];
            } else {
                throw new Exception('The file does not match the CSV format. The data could not be found in the correct format.');
            }
        } else {
            throw new Exception('The file could not be opened for reading.');
        }
    }
}
