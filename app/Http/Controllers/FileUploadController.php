<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FileReaderInterface;
use App\Repositories\UserRepositoryInterface;

class FileUploadController extends Controller
{
    private FileReaderInterface $fileReader;
    private UserRepositoryInterface $userRepository;

    public function __construct(FileReaderInterface $fileReader, UserRepositoryInterface $userRepository)
    {
        $this->fileReader = $fileReader;
        $this->userRepository = $userRepository;
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv|max:2048',
        ]);

        $file = $request->file('file');

        try {
            $data = $this->fileReader->readData($file->getPathname());

            $this->userRepository->insertUsers($data);

            return response()->json(['message' => 'Выполнено'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
