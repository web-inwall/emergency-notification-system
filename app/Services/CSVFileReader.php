<?php

namespace App\Services;

class CSVFileReader implements FileReaderInterface
{
    public function readData(string $filePath): array
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new \Exception('Не удалось открыть файл.');
        }

        $data = [];
        if (($file = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($file)) !== false) {
                if (count($row) >= 3 && !empty(trim($row[0])) && !empty(trim($row[1])) && !empty(trim($row[2]))) {
                    $data[] = [
                        'bio' => trim($row[0]),
                        'link' => trim($row[1]),
                        'adress' => trim($row[2]),
                    ];
                }
            }
            fclose($file);
        }

        return $data;
    }
}