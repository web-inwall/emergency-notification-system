<?php

namespace App\Services;

interface FileReaderInterface
{
    public function readData(string $filePath): array;
}