<?php

namespace App\Services;

use App\Services\FileReaderInterface;
use Exception;

class FileReaderService implements FileReaderInterface
{
    public function readData(string $filePath): array
    {
        $fileContent = file_get_contents($filePath);

        $lines = explode(PHP_EOL, $fileContent);
        $data = [];

        if (!empty($lines)) {
            foreach ($lines as $line) {
                $row = str_getcsv($line);

                if (count($row) == 3 && !empty(trim($row[0])) && !empty(trim($row[1])) && !empty(trim($row[2]))) {
                    $data[] = [
                        'bio' => trim($row[0]),
                        'link' => trim($row[1]),
                        'address' => trim($row[2]),
                    ];
                }
            }

            if (count($data) > 0) {
                return $data;
            } else {
                throw new Exception('Файл не соответствует формату CSV. Не удалось найти данные в правильном формате.');
            }
        } else {
            throw new Exception('Файл пуст или не удалось прочитать данные.');
        }
    }
}