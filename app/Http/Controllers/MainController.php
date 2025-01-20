<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Interfaces\FileReaderInterface;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\MainControllerInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Requests\FormValidationRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\FullFormValidationRequest;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\NotificationUserRepositoryInterface;
use App\Interfaces\SendNotificationControllerInterface;

class MainController extends Controller implements MainControllerInterface
{
    private $fileReader;
    private $userRepository;
    private $notificationRepository;
    private $notificationUserRepository;
    private $sendNotificationController;

    public function __construct(FileReaderInterface $fileReader, UserRepositoryInterface $userRepository, NotificationRepositoryInterface $notificationRepository, NotificationUserRepositoryInterface $notificationUserRepository, SendNotificationControllerInterface $sendNotificationController)
    {
        $this->fileReader = $fileReader;
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
        $this->notificationUserRepository = $notificationUserRepository;
        $this->sendNotificationController = $sendNotificationController;
    }

    public function manageUserNotificationWorkflow(FormValidationRequest $request)
    {
        $templateName = $request->input('template_name');

        $message = $request->has('userMessage') ? $request->input('userMessage') : $request->input('selectedTemplateMessage');

        $requestAllDataForm = new FullFormValidationRequest();

        $validator = Validator::make($request->all(), $requestAllDataForm->rules());

        if ($request->hasFile('file')) {
            if ($validator->passes()) {

                $file = $request->file('file'); // получаем информацию о файле
                // $message = $request->input('message'); // получаем введенное сообщение
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

                    // Отправка уведомлений пользователям
                    $this->sendNotificationController->processingFormData($data, $templateName, $message);

                    // return response()->json(['message' => 'Выполнено'], 200);
                    // return redirect()->to('/');

                } catch (Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            } else {
                throw ValidationException::withMessages($validator->errors()->messages());
            }
        } else {
            // dd('данные введены автоматически');
            $this->sendNotificationController->processingTemplateData($templateName, $message);
        }
    }
}
