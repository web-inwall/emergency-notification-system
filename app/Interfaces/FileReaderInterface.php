<?php

namespace App\Interfaces;

interface FileReaderInterface
{
    public function readData(string $filePath): array;
}
