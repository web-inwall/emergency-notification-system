<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\FileReaderInterface;
use App\Services\NotificationInterface;
use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\MessageAndFileUploadRequest;

class MessageAndFileUploadController extends Controller
{
    private $fileReader;
    private $userRepository;
    private $notification;

    public function __construct(FileReaderInterface $fileReader, UserRepositoryInterface $userRepository, NotificationInterface $notification)
    {
        $this->fileReader = $fileReader;
        $this->userRepository = $userRepository;
        $this->notification = $notification;
    }

    public function importUsersAndNotify(MessageAndFileUploadRequest $request)
    {
        $file = $request->file('file'); // получаем информацию о файле
        $templateName = $request->input('template_name'); // получаем имя шаблона
        $message = $request->input('message'); // получаем введенное сообщение
        $filePath = $file->getPathname();

        try {
            // Чтение данных из файла
            $data = $this->fileReader->readData($filePath); // в $data будет массив массивов с ключами и их значениями

            // Вставка пользователей в БД
            $this->userRepository->insertUsers($data['data']);

            // Отправка уведомлений пользователям
            $this->notification->sendNotifications($templateName, $message, $data);

            return response()->json(['message' => 'Выполнено'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        // return redirect()->to('/');
    }
}