<?php

namespace App\Services;

use App\Interfaces\FileReaderInterface;
use Exception;

class FileReaderService implements FileReaderInterface
{
    public function readData(string $filePath): array
    {
        try {
            $handle = fopen($filePath, 'r');
            if ($handle === false) {
                throw new Exception('The file could not be opened for reading.');
            }

            $csvData = [];
            $batchId = uniqid();

            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) == 3 && ! empty(trim($row[0])) && ! empty(trim($row[1])) && ! empty(trim($row[2]))) {
                    $csvData[] = [
                        'bio' => trim($row[0]),
                        'link' => trim($row[1]),
                        'address' => trim($row[2]),
                        'batch_id' => $batchId,
                    ];
                }
            }

            fclose($handle);

            if (empty($csvData)) {
                throw new Exception('The file does not match the CSV format. The data could not be found in the correct format.');
            }

            return ['batchId' => $batchId, 'data' => $csvData];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
