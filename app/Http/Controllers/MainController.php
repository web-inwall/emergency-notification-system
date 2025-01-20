<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormValidationRequest;
use App\Interfaces\FileReaderInterface;
use App\Interfaces\MainControllerInterface;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\NotificationUserRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;


class MainController extends Controller implements MainControllerInterface
{
    private $fileReader;
    private $userRepository;
    private $notificationRepository;
    private $notificationUserRepository;
    // private $notification;

    public function __construct(FileReaderInterface $fileReader, UserRepositoryInterface $userRepository, NotificationRepositoryInterface $notificationRepository, NotificationUserRepositoryInterface $notificationUserRepository)
    {
        $this->fileReader = $fileReader;
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
        $this->notificationUserRepository = $notificationUserRepository;
        // $this->notification = $notification;
    }

    public function manageUserNotificationWorkflow(FormValidationRequest $request)
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

            // Вставка уведомления в БД
            $groupNotification = $this->notificationRepository->createNotification($templateName, $message);

            // Вставка данных в таблицу связи
            $this->notificationUserRepository->createNotificationUsers($data, $groupNotification);

            // Вывод сохраненного шаблона

            // Отправка уведомлений пользователям
            // $this->notification->sendNotifications($templateName, $message, $data);

            // return response()->json(['message' => 'Выполнено'], 200);
            return redirect()->to('/');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
