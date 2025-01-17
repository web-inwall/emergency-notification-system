<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FileReaderInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\NotificationService;

class FileUploadController extends Controller
{
    private FileReaderInterface $fileReader;
    private UserRepositoryInterface $userRepository;
    private NotificationService $notificationService;

    public function __construct(FileReaderInterface $fileReader, UserRepositoryInterface $userRepository, NotificationService $notificationService)
    {
        $this->fileReader = $fileReader;
        $this->userRepository = $userRepository;
        $this->notificationService = $notificationService;
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv|max:2048',
        ]);

        $file = $request->file('file');

        try {
            // Чтение данных из файла
            $data = $this->fileReader->readData($file->getPathname());

            // Вставка пользователей в БД
            $this->userRepository->insertUsers($data);

            // Отправка уведомлений пользователям
            $this->notificationService->sendNotifications($data);

            return response()->json(['message' => 'Выполнено'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}